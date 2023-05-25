<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Models\VendingMachine;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function registerSupplier(Request $req)
    {
        //
      
            $new_supplier = User::create([
                'userName' =>$req->userName,
                'email'=>$req->email,
                'password'=>$req->password,
                'userType'=> "Supplier"
            ]);
            if($new_supplier){
                return response()->json(['message' => 'Register supplier successfully!'],200);
            }else{
                return response()->json(['message' => 'something went wrong!'],404);
            }
       
    }

    public function getSupplierList(){
        $users = DB::table('user')
        ->select('userID','userName','email', 'userType')
        ->where('userType', 'Supplier')
        ->get();

         return response()->json($users);
    }
    public function updateStock(Request $req,$vendingMachineID){
        try{
        $vending_machine = VendingMachine::findOrFail($vendingMachineID);
        $product_items = $req->items;

          foreach ($product_items as $item) {
           
            $product = ProductStock::where('stockName', $item['stockName'])->first();
            $supplierID = DB::table('user')
                ->where('userName', $item['supplierName'])
                ->where('userType', 'Supplier')
                ->value('userID');

                DB::table('product_vending_machine')
                ->where('stockID', $product['stockID'])
                ->where('vendingMachineID', $vendingMachineID)
                ->update([
                    'stockQuantity' => DB::raw('stockQuantity + '.$item['suppliedQuantity'])
                ]);

                return response()->json(['message'=> 'Item supplied successfully!'],200);
           
          }
        }catch(Exception $e){
            return response()->json(['message'=> $e->getMessage()],404);
        }
                
    }

    public function sendNotification(){
        
    }

}
