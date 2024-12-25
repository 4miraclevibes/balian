<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\StockDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class TransactionController extends Controller
{
    protected $ssoUrl;

    public function __construct()
    {
        $this->ssoUrl = env('SSO_API_URL');
    }

    public function index(Request $request)
    {
        try {
            $defaultStatus = Auth::user()->role->name == 'driver' ? 'shipped' : 'all';
            $status = $request->query('status', $defaultStatus);

            if (Auth::user()->role->name == 'user') {
                $status = $request->query('status', 'all');
                $query = Transaction::where('user_id', Auth::user()->id)
                    ->with('details.variant.product', 'payment', 'user', 'payment.user');
            } else {
                $query = Transaction::with('details.variant.product', 'payment', 'user', 'payment.user')
                    ->whereHas('payment', function($q) {
                        $q->where('user_id', Auth::user()->id);
                    });
            }

            $statusMapping = [
                'shipped' => ['shipped', 'delivered'],
                'delivered' => ['done'],
                'cancelled' => ['cancelled'],
                'pending' => ['pending'],
                'processing' => ['processing']
            ];

            if ($status !== 'all' && isset($statusMapping[$status])) {
                if (count($statusMapping[$status]) > 1) {
                    $query->whereIn('status', $statusMapping[$status]);
                } else {
                    $query->where('status', $statusMapping[$status][0]);
                }
            }

            $transactions = $query->latest()->get();

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Transactions retrieved successfully',
                'data' => $transactions
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'An error occurred while retrieving transactions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'total_price' => 'required|numeric|min:0',
                'checked_items' => 'required|array',
                'checked_items.*' => 'exists:carts,id',
                'quantities' => 'required|array',
                'quantities.*' => 'integer|min:1',
                'shipping_price' => 'required|numeric|min:0',
                'app_fee' => 'required|numeric|min:0',
                'notes' => 'nullable|string'
            ]);


            $checkedCarts = Cart::whereIn('id', $validatedData['checked_items'])
            ->where('user_id', Auth::user()->id)
            ->get();


            if(Auth::user()->userAddress->where('status', 'active')->first() == null){
                return response()->json([
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'User tidak memiliki alamat'
                ], 400);
            }

            $total = 0;
            foreach ($checkedCarts as $cart) {
                $quantity = $validatedData['quantities'][$cart->id];
                $price = $cart->variant->price;
                $total += $quantity * $price;
            }

            if($total <= 5000){
                return response()->json([
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Minimal pembelian Rp. 5.000'
                ], 400);
            }

            if($total !== $validatedData['total_price']){
                return response()->json([
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Ada update harga'
                ], 400);
            }

            DB::beginTransaction();

            foreach($checkedCarts as $cart) {
                $productVariant = $cart->variant;
                $quantityToUpdate = $validatedData['quantities'][$cart->id];
                $availableStockDetails = $productVariant->getAvailableStockDetails();

                if ($availableStockDetails->count() < $quantityToUpdate) {
                    throw new \Exception("Stok tidak cukup untuk produk {$productVariant->product->name} - {$productVariant->name}");
                }
            }
            $transactionAddress = Auth::user()->userAddress->where('status', 'active')->first();
            $longitude = $transactionAddress->longitude;
            $latitude = $transactionAddress->latitude;
            $phone = $transactionAddress->receiver_phone;
            $receiver = $transactionAddress->receiver_name;

            $transaction = Transaction::create([
                'total_price' => $validatedData['total_price'],
                'code' => $this->generateTransactionCode(),
                'user_id' => Auth::user()->id,
                'status' => 'pending',
                'shipping_price' => $validatedData['shipping_price'],
                'app_fee' => $validatedData['app_fee'],
                'notes' => $validatedData['notes'],
                'address' => $transactionAddress->subDistrict->name . ' | ' . $transactionAddress->address. ' | ' . $receiver . ' | ' . $phone . ' | ' . $longitude . ' | ' . $latitude
            ]);

            foreach($checkedCarts as $cart) {
                $transactionDetail = TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'variant_id' => $cart->variant_id,
                    'quantity' => $validatedData['quantities'][$cart->id],
                    'price' => $cart->variant->price,
                    'capital_price' => $cart->variant->getCapitalPriceForQuantity($validatedData['quantities'][$cart->id]),
                ]);

                $productVariant = $cart->variant;
                $quantityToUpdate = $validatedData['quantities'][$cart->id];
                $availableStockDetails = $productVariant->getAvailableStockDetails();
                $updateIds = $availableStockDetails->take($quantityToUpdate)->pluck('id')->toArray();

                $updatedCount = StockDetail::whereIn('id', $updateIds)
                    ->where('status', 'ready')
                    ->update([
                        'status' => 'sold',
                        'price' => $transactionDetail->price,
                    ]);

                if ($updatedCount != $quantityToUpdate) {
                    throw new \Exception("Terjadi perubahan stok untuk produk {$productVariant->product->name} - {$productVariant->name}");
                }
            }

            $checkedCarts->each->delete();
            DB::commit();

            return response()->json([
                'code' => 201,
                'status' => 'success',
                'message' => 'Transaction created successfully',
                'data' => $transaction
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'code' => 422,
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'An error occurred while creating the transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        try {
            $validatedData = $request->validate([
                'status' => 'required|in:pending,processing,shipped,delivered,done,cancelled',
            ]);

            $transaction->update([
                'status' => $validatedData['status'],
            ]);

            if($validatedData['status'] == 'cancelled'){
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
            }

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Transaction status updated successfully',
                'data' => $transaction
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'code' => 422,
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'An error occurred while updating the transaction status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function markAsDone(Transaction $transaction)
    {
        try {
            if ($transaction->user_id !== Auth::id() && $transaction->payment->user_id !== Auth::id()) {
                return response()->json([
                    'code' => 403,
                    'status' => 'error',
                    'message' => 'You do not have permission to mark this transaction as done'
                ], 403);
            }

            if ($transaction->status !== 'delivered') {
                return response()->json([
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Only transactions with "Delivered" status can be marked as done'
                ], 400);
            }

            DB::beginTransaction();

            $payment = Payment::where('code', $transaction->payment->code)->first();
            if ($payment && $payment->status == 'success') {
                $transaction->update(['status' => 'done']);
                DB::commit();
                return response()->json([
                        'code' => 200,
                        'status' => 'success',
                        'message' => 'Transaction marked as done successfully'
                ], 200);
            } else {
                DB::rollBack();
                return response()->json([
                        'code' => 404,
                        'status' => 'error',
                        'message' => 'Payment not found'
                ], 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'An error occurred while marking the transaction as done',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function pay(Transaction $transaction)
    {
        try {
            if ($transaction->user_id !== Auth::id() && $transaction->payment->user_id !== Auth::id()) {
                return response()->json([
                'code' => 403,
                    'status' => 'error',
                    'message' => 'You do not have permission to pay for this transaction'
                ], 403);
            }

            if ($transaction->status !== 'delivered') {
                return response()->json([
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Only transactions with "Delivered" status can be paid'
                ], 400);
            }

            return redirect()->away('https://m.edupay.cloud/dashboard');
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'An error occurred while paying for the transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function generateTransactionCode()
    {
        $latestTransaction = Transaction::latest()->first();
        $transactionId = $latestTransaction ? $latestTransaction->id + 1 : 1;

        $now = Carbon::now();
        $userId = Auth::id();

        $code = sprintf(
            "TRX - %d%d%02d%02d%02d",
            $userId,
            $transactionId,
            $now->day,
            $now->month,
            $now->year % 100
        );

        return $code;
    }
}
