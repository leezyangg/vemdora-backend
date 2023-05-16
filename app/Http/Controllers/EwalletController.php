<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EwalletController extends Controller
{
    public function checkEwalletBalance($ewalletid){

    }

    public function getEwallet($userid){
        $ewalletId = DB::table('user')->select('walletID')->where('userID',$userid)->first();
        $e_wallet = EWallet::find($ewalletId);

        if($e_wallet){
            return response()->json($e_wallet);
        }else{
            return response()->json(['message'=>'E wallet not found...']);
        }
    }
}
