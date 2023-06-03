<?php

namespace App\Jobs;

use App\Models\ProductStock;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class StockCheckJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $products = DB::table('product_vending_machine')
            ->where('stockQuantity', '<', 5)
            ->get();

        foreach ($products as $product) {
            // Generate your alert logic here (e.g., sending an email to your supplier)
            $found_item = DB::table('product_stock')
                 ->join('user', 'product_stock.supplier_id', '=', 'user.userID')
                 ->select('user.email','product_stock.stockName')
                 ->where('stockID', '=', $product['stockID'])
                 ->get();

            error_log('lOW IN STOCK:'. $found_item->stockName);
            // Mail::raw("Low stock alert for product: " . $found_item->stockName, function ($message) {
            //     $message->to($found_item->email)->subject('Low Stock Alert');
            // });
        }
    }
}
