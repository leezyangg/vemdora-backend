<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Models\VendingMachine;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getTopProducts(){
    try{
        //get the top 5 product based on their sales
        $topProducts = DB::table('order_product')
        ->select('order_product.stockID',DB::raw('SUM(order_product.orderedQuantity * product_stock.buyPrice) as totalCost'),DB::raw('SUM(order_product.orderedQuantity * product_stock.sellPrice) as totalSales'))
        ->join('product_stock', 'order_product.stockID', '=', 'product_stock.stockID')
        ->groupBy('order_product.stockID')
        ->orderByDesc('totalSales')
        ->limit(5)
        ->get();

    $products = [];

    
    // calculate profit for each products
    foreach ($topProducts as $topProduct) {
        $product = ProductStock::find($topProduct->stockID);
        $product->totalSales = $topProduct->totalSales;
        $product->profit = $product->totalSales - ($topProduct->totalCost);
        $products[] = $product;
    }

    //return the response
    return response()->json(['topProducts' => $products], 200);
    }catch(Exception $e){
        return response()->json(['message' => 'something went wrong...','error' => $e->getMessage()], 400);
    }
    }



    public function getTopVendingMachines(){
        try{
        //get the top 5 vending machine from DB
        $topVendingMachines = DB::table('order')
        ->select('order.vendingMachineID', DB::raw('SUM(order_product.orderedQuantity * product_stock.sellPrice) as totalSales'), DB::raw('SUM(order_product.orderedQuantity * (product_stock.sellPrice - product_stock.buyPrice)) as totalProfit'))
        ->join('order_product', 'order.orderID', '=', 'order_product.orderID')
        ->join('product_stock', 'order_product.stockID', '=', 'product_stock.stockID')
        ->groupBy('order.vendingMachineID')
        ->orderByDesc('totalSales')
        ->limit(5)
        ->get();

    $vendingMachines = [];
    
    //loop the VMs to obtain data
    foreach ($topVendingMachines as $vendingMachine) {
        $vendingMachineData = [
            'vendingMachineID' => $vendingMachine->vendingMachineID,
            'totalSales' => $vendingMachine->totalSales,
            'totalProfit' => $vendingMachine->totalProfit,
        ];

        $vendingMachines[] = $vendingMachineData;
    }

    return response()->json(['topVendingMachines' => $vendingMachines], 200);
    }catch(Exception $e){
        return response()->json(['message' => 'something went wrong...','error' => $e->getMessage()], 400);

    }
    }
}
