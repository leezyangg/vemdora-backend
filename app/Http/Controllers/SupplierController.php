<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
    public function updateStock(){

    }

    public function sendNotification(){
        
    }

}
