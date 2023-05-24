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

    return response()->json(['topProducts' => $products], 200);
    }



    public function getTopVendingMachines(){
        $topVendingMachines = DB::table('order')
        ->select('order.vendingMachineID', DB::raw('SUM(order_product.orderedQuantity * product_stock.sellPrice) as totalSales'), DB::raw('SUM(order_product.orderedQuantity * (product_stock.sellPrice - product_stock.buyPrice)) as totalProfit'))
        ->join('order_product', 'order.orderID', '=', 'order_product.orderID')
        ->join('product_stock', 'order_product.stockID', '=', 'product_stock.stockID')
        ->groupBy('order.vendingMachineID')
        ->orderByDesc('totalSales')
        ->limit(5)
        ->get();

    $vendingMachines = [];

    foreach ($topVendingMachines as $vendingMachine) {
        $vendingMachineData = [
            'vendingMachineID' => $vendingMachine->vendingMachineID,
            'totalSales' => $vendingMachine->totalSales,
            'totalProfit' => $vendingMachine->totalProfit,
        ];

        $vendingMachines[] = $vendingMachineData;
    }

    return response()->json(['topVendingMachines' => $vendingMachines], 200);
    }
}
