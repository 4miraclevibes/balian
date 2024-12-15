<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class PaymentController extends Controller
{
    protected $ssoUrl;

    public function __construct()
    {
        // Mengambil URL SSO dari environment variables
        $this->ssoUrl = env('SSO_API_URL');
    }
    public function store(Request $request, Transaction $transaction)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        if($transaction->payment != null){
            Payment::where('transaction_id', $transaction->id)->update([
                'user_id' => $request->user_id,
                'operator' => Auth::user()->name
            ]);
            return redirect()->route('dashboard.transaction.deliveries')->with('success', 'Berhasil mengubah driver');
        }

        DB::beginTransaction();
        try {
            $transaction = Transaction::find($transaction->id);
            $token = session('sso_token');
            if (!$token) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->post("{$this->ssoUrl}/payment/store", [
                'service_id' => 8,
                'total' => $transaction->total_price + $transaction->shipping_price,
            ]);
            if ($response->successful()) {
                $payment = Payment::create([
                    'user_id' => $request->user_id,
                    'transaction_id' => $transaction->id,
                    'operator' => Auth::user()->name,
                    'status' => 'pending',
                    'amount' => $response->json('data.total'),
                    'code' => $response->json('data.code'),
                ]);
                DB::commit();
                $transaction->update([
                    'code' => $payment->code,
                    'status' => 'delivered'
                ]);
                return redirect()->route('dashboard.transaction.deliveries')->with('success', 'Berhasil membuat pembayaran');
            } else {
                if ($response->json('code') == 422 || $response->json('code') == 500) {
                    DB::rollBack();
                    return back()->with('success', $response->json());
                }
                // Jika gagal, kembalikan response error
                DB::rollBack();
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (Exception $e) {
            // Log the exception
            Log::error('Error storing payment: ' . $e->getMessage());

            // Rollback the transaction
            DB::rollBack();

            // Return an error response
            return response()->json(['error' => 'Something went wrong, please try again later'], 500);
        }
        return redirect()->route('dashboard.transaction.deliveries')->with('success', 'Driver berhasil di set');
    }
}
