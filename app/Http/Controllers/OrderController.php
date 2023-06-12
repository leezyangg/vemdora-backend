<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\EWallet;
use App\Mail\sendInvoice;
use App\Models\Transaction;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\QueryException;
use File;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return 'test order controller';
        $orders = Order::all();

        return response()->json($orders);
    }

    public function getEwallet($userid)
    {
        try {
            $ewalletId = DB::table('user')->select('walletID')->where('userID', $userid)->value('walletID');;
            $e_wallet = EWallet::find($ewalletId);

            if ($e_wallet) {
                return $e_wallet;
            } else {
                return response()->json(['message' => 'E wallet not found...'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'something went wrong...', 'error' => $e->getMessage()], 400);
        }
    }
    public function calculateTotalPrice(Request $req)
    {
        try {
            $items = $req->items;
            $total = 0;
            //loop all items in list and sum the total
            foreach ($items as $item) {

                $quantity = $item['orderedQuantity'];

                $unit_total = $quantity * $item['sellPrice'];
                $total += $unit_total;
            }
            //return response()->json(['total' => $total]);
            return $total;
        } catch (Exception $e) {
            return response()->json(['message' => 'something went wrong...', 'error' => $e->getMessage()], 400);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function placeOrder(Request $req, $vendingMachineID, $userID)
    {

        try {

            $items = $req->items;
            error_log('Items: ' . print_r($items, true));

            //calculate the total amount
            $transactionAmount = $this->calculateTotalPrice($req);
            error_log($transactionAmount);
            //$transactionID = 0;
            //find user's ewallet
            $e_wallet = $this->getEwallet($userID);
            //create transaction if ewallet is found
            if ($e_wallet instanceof EWallet) {
                $balance = $e_wallet->walletValue;
                //only allow transaction if balance is enough
                if ($balance >= $transactionAmount) {
                    $transaction = Transaction::create([
                        'transactionDate' => Carbon::now(),
                        'transactionAmount' => $transactionAmount
                    ]);
                    if ($transaction) {

                        $order = Order::create([
                            'publicID' => $userID,
                            'vendingMachineID' => $vendingMachineID,
                            'transactionID' => $transaction->transactionID
                        ]);
                        $e_wallet->walletValue -= $transactionAmount;
                        $e_wallet->save();
                    }
                } else {
                    return response()->json(['message' => 'Not enough balance'], 404);
                }
            } else {
                return response()->json(['message' => 'E wallet not found...'], 404);
            }
            // insert order record

            // $order = Order::create([
            //         'publicID' => $userID,
            //         'vendingMachineID' => $vendingMachineID,
            //         'transactionID' => $transactionID
            //     ]);
            //find user email
            $user = DB::table('user')->where('userID', $userID)->first();
            $user_email = $user->email;

            foreach ($items as $item) {
                //find item id in database
                $found_item = ProductStock::where('stockName', $item['stockName'])->first();
                $itemId = $found_item['stockID'];
                $quantity = $item['orderedQuantity'];
                //attach the item in pivot table with the ordered quantity
                $order->productItems()->attach($itemId, ['orderedQuantity' => $quantity]);

                // Update stock quantity in product_vending_machine pivot table
                DB::table('product_vending_machine')->where([
                    'vendingMachineID' => $vendingMachineID,
                    'stockID' => $itemId
                ])->decrement('stockQuantity', $quantity);
            }

            //send invoice email to user after order
            $data = ['time' => Carbon::now()];
            Mail::to($user_email)->send(new sendInvoice($data));

            return response()->json([
                'message' => 'Order placed successfully',
                'orderID' => $order->orderID,
                'total' => $transactionAmount
            ], 200);
        } catch (QueryException $e) {

            return response()->json(['message' => 'Error placing order', 'error' => $e->getMessage()], 500);
        } catch (Exception $e) {

            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::find($id);

        if ($order) {
            return response()->json($order);
        }

        return response()->json(['message' => 'Purchase not found'], 404);
    }
    public function getSales()
    {
        $path = database_path('data/sales.json');
        $json = File::get($path);
        $data = json_decode($json);
        return response()->json($data);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
