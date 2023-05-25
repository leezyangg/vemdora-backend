<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\EWallet;
use App\Models\Transaction;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

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

    public function getEwallet($userid){
        $ewalletId = DB::table('user')->select('walletID')->where('userID',$userid)->value('walletID');;
        $e_wallet = EWallet::find($ewalletId);

        if($e_wallet){
            return $e_wallet;
        }else{
            return response()->json(['message' => 'E wallet not found...'], 404);
        }
    }
    public function calculateTotalPrice(Request $req){
        $items = $req->items;
        $total = 0;
        foreach ($items as $item) {
            
            $quantity = $item['orderedQuantity'];
    
            $unit_total = $quantity * $item['sellPrice'];
            $total += $unit_total;
        }
        //return response()->json(['total' => $total]);
        return $total;

    }
    /**
     * Store a newly created resource in storage.
     */
    public function placeOrder(Request $req,$vendingMachineID,$userID)
    {
       
        try {
        
            $items = $req->items;
            $transactionAmount = $this->calculateTotalPrice($req);
            $e_wallet = $this->getEwallet($userID);
            if ($e_wallet instanceof EWallet) {
                 $balance = $e_wallet->walletValue;
                if($balance >= $transactionAmount){
                     $transactions = Transaction::create([
                        'transactionDate'=> Carbon::now(),
                        'transactionAmount' => $transactionAmount
                     ] );

                     //deduct the wallet value
                     $e_wallet->walletValue -= $transactionAmount;
                     $e_wallet->save();


                }else{
                     return response()->json(['message' => 'Not enough balance'], 404);
            }
        }else{
            return response()->json(['message' => 'E wallet not found...'], 404);
        }
            // insert order record
            $order = Order::create([
                    'publicID' => $userID,
                    'vendingMachineID' => $vendingMachineID,
                    'transactionID' => 1
                ]);

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
    
           
    
            return response()->json([
                'message' => 'Order placed successfully', 
                'orderID' => $order->orderID,
                'total'=> $transactionAmount
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
