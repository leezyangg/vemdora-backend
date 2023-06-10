<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\EWallet;
use App\Models\Transaction;
use App\Models\ProductStock;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EwalletController;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use File;
class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderController = new OrderController();
        $walletController = new EwalletController();
        $json = File::get("database\data\order.json");
        $order = json_decode($json);
       
        foreach($order as $key => $value)
        {
        $items = $value->items;
        //calculate the total amount
        $transactionAmount = $orderController->calculateTotalPrice($value);
        //find user's ewallet
        $e_wallet = $walletController->getEwallet($value->publicID);
        //create transaction if ewallet is found
        if ($e_wallet instanceof EWallet) {
             $balance = $e_wallet->walletValue;
             //only allow transaction if balance is enough
            if($balance >= $transactionAmount){
                 $transactions = Transaction::create([
                    'transactionDate'=> Carbon::now(),
                    'transactionAmount' => $transactionAmount
                 ] );

                 //deduct the wallet value
                 $e_wallet->walletValue -= $transactionAmount;
                 $e_wallet->save();


            }else{
                 echo 'not enough balance';
        }
    }else{
       echo 'ewallet not found';
    }
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
    }
    }
}
