<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\MailSender;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Models\VendingMachine;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SupplierController extends Controller
{
    public function registerSupplier(Request $req)
    {
        try{
        //register new supplier
      
            $new_supplier = User::create([
                'companyName' => $req->companyName,
                'userName' =>$req->pic,
                'email'=>$req->email,
                'password'=>$req->password,
                'userType'=> "Supplier"
            ]);
            if($new_supplier){
                return response()->json(['message' => 'Register supplier successfully!'],200);
            }else{
                return response()->json(['message' => 'something went wrong!'],404);
            }
        }catch(Exception $e){
            return response()->json(['message' => 'something went wrong...','error' => $e->getMessage()], 400);

        }
       
    }

    public function getSupplierList(){
        try{
        $users = DB::table('user')
        ->select('userID','userName','email', 'userType')
        ->where('userType', 'Supplier')
        ->get();

         return response()->json($users);
        }catch(Exception $e){
            return response()->json(['message' => 'something went wrong...','error' => $e->getMessage()], 400);

        }
    }
    public function updateStock(Request $req,$vendingMachineID){
        try{
        //find the vending machine in db
        $vending_machine = VendingMachine::findOrFail($vendingMachineID);
        $product_items = $req->items;

          foreach ($product_items as $item) {
            //find product to retrive it id
            $product = ProductStock::where('stockName', $item['stockName'])->first();
            //find the supplier of product
            $supplierID = DB::table('user')
                ->where('userName', $item['supplierName'])
                ->where('userType', 'Supplier')
                ->value('userID');

                // update the stockQuantity
                DB::table('product_vending_machine')
                ->where('stockID', $product['stockID'])
                ->where('vendingMachineID', $vendingMachineID)
                ->update([
                    'stockQuantity' => DB::raw('stockQuantity + '.$item['suppliedQuantity'])
                ]);

                return response()->json(['message'=> 'Your update was succesful !'],200);
           
          }
        }catch(Exception $e){
            return response()->json(['message'=> $e->getMessage()],404);
        }
                
    }

    public function sendNotification(){
        $products = DB::table('product_vending_machine')
        ->where('stockQuantity', '<', 5)
        ->get();
        $low_in_stock = [];
    foreach ($products as $product) {
        // Generate your alert logic here (e.g., sending an email to your supplier)
        $found_item = DB::table('product_stock')
             ->join('user', 'product_stock.supplierID', '=', 'user.userID')
             ->select('user.email','product_stock.stockName')
             ->where('product_stock.stockID', '=', $product->stockID)
             ->get();

        $low_in_stock []=  $found_item;
        

        // Mail::raw("Low stock alert for product: " . $found_item->stockName, function ($message) {
        //     $message->to($found_item->email)->subject('Low Stock Alert');
        // });

        if(!empty($low_in_stock)){
            foreach($low_in_stock as $stocks){
                foreach($stocks as $stock){
                    $data = ['stockName' => $stock->stockName, 'body'=>'Please supply it'];
                    Mail::to('choongwenjian@gmail.com')->send(new MailSender($data));
                }
            }
        }
    }
   
    return response()->json(['low in stock' =>  $low_in_stock], 200);

    }

}
