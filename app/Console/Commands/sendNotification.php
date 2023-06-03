<?php

namespace App\Console\Commands;

use App\Mail\MailSender;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class sendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()

    {
        $data = [];
        //get the product that are below minimum treshold
        $products = DB::table('product_vending_machine')
        ->where('stockQuantity', '<', 5)
        ->get();
        $low_in_stock = [];
    foreach ($products as $product) {
        // Generate your alert logic here (e.g., sending an email to your supplier)
        //get the supplier email and products
        $found_item = DB::table('product_stock')
             ->join('user', 'product_stock.supplierID', '=', 'user.userID')
             ->select('user.email','product_stock.stockName')
             ->where('product_stock.stockID', '=', $product->stockID)
             ->get();

        $low_in_stock []=  $found_item;

        //Mail::to('choongwenjian@gmail.com')->send(new MailSender());
       
    }

    if(!empty($low_in_stock)){
        foreach($low_in_stock as $stocks){
            foreach($stocks as $stock){
                //if there is item found below minimum stock, send email
                $data = ['stockName' => $stock->stockName, 'body'=>'Please supply it'];
                Mail::to('choongwenjian@gmail.com')->send(new MailSender($data));
            }
        }
    }
    }
}
