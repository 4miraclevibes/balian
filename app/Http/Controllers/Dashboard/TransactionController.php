<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\StockDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user')->latest()->get();
        return view('pages.dashboard.transactions.index', compact('transactions'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        DB::beginTransaction();
        try {
            if ($request->status == 'cancelled' && $transaction->status != 'cancelled') {
                // Mengubah status StockDetail dari 'sold' ke 'ready'
                foreach ($transaction->details as $detail) {
                    $quantity = $detail->quantity;

                    $stockDetails = StockDetail::whereHas('variantStock', function ($query) use ($detail) {
                        $query->where('product_variant_id', $detail->variant_id);
                    })
                    ->where('status', 'sold')
                    ->orderBy('created_at', 'desc')
                    ->take($quantity)
                    ->get();

                    foreach ($stockDetails as $stockDetail) {
                        $stockDetail->update(['status' => 'ready']);
                    }
                }
            } elseif ($transaction->status == 'cancelled' && in_array($request->status, ['pending', 'processing', 'shipped', 'delivered'])) {
                // Mengubah status StockDetail dari 'ready' ke 'sold'
                foreach ($transaction->details as $detail) {
                    $quantity = $detail->quantity;

                    $stockDetails = StockDetail::whereHas('variantStock', function ($query) use ($detail) {
                        $query->where('product_variant_id', $detail->variant_id);
                    })
                    ->where('status', 'ready')
                    ->orderBy('created_at', 'asc')
                    ->take($quantity)
                    ->get();

                    foreach ($stockDetails as $stockDetail) {
                        $stockDetail->update(['status' => 'sold']);
                    }
                }
            }

            $transaction->update(['status' => $request->status]);
            DB::commit();

            return redirect()->route('dashboard.transaction.index')->with('success', 'Status transaksi berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('dashboard.transaction.index')->with('error', 'Gagal mengubah status transaksi: ' . $e->getMessage());
        }
    }

    public function show(Transaction $transaction)
    {
        return view('pages.dashboard.transactions.show', compact('transaction'));
    }

    public function deliveries()
    {
        $transactions = Transaction::where('status', 'shipped')
            ->whereDoesntHave('payment')
            ->orWhereHas('payment', function($query) {
                $query->where('status', 'pending');
            })
            ->get();

        $users = User::whereHas('role', function($query) {
            $query->where('name', 'driver');
        })->get();

        return view('pages.dashboard.deliveries.index', compact('transactions', 'users'));
    }

    public function assignDelivery(Request $request, Transaction $transaction)
    {
        $request->validate([
            'driver_id' => 'required|exists:users,id',
        ]);

        $transaction->update(['status' => 'shipped', 'driver_id' => $request->driver_id]);
    }

    public function fresh()
    {
        $transactions = Transaction::all();
        foreach ($transactions as $transaction) {
            $transaction->delete();
        }
        return 'success';
    }
}
