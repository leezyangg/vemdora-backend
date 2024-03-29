<?php

namespace App\Http\Controllers;

use App\Models\EWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EwalletController extends Controller
{
    // public function checkEwalletBalance($ewalletid){

    // }

    public function getEwallet($userid){
        $ewalletId = DB::table('user')->select('walletID')->where('userID',$userid)->value('walletID');;
        $e_wallet = EWallet::find($ewalletId);

        if($e_wallet){
            return response()->json($e_wallet);
        }else{
            return response()->json(['message'=>'E wallet not found...']);
        }
    }

    public function getEwalletAmount($userid){
        $ewalletId = DB::table('user')->select('walletID')->where('userID',$userid)->value('walletID');;
        $e_wallet = EWallet::find($ewalletId);

        if($e_wallet){
            return response()->json($e_wallet->walletValue);
        }else{
            return response()->json(['message'=>'E wallet not found...'],404);
        }
    }

    public function topUp(Request $req,$userid){
        $ewalletId = DB::table('user')->select('walletID')->where('userID',$userid)->value('walletID');;
        $e_wallet = EWallet::find($ewalletId);

       
        if ($e_wallet) {
            $affectedRows = EWallet::where('walletID', $ewalletId)
                ->update(['walletValue' => DB::raw('walletValue + ' . $req->topUpAmount)]);
    
            if ($affectedRows) {
                return response()->json(['message' => 'Wallet topped up successfully','topUpAmount'=>$req->topUpAmount],200);
            }else{
                return response()->json(['message' => 'Wallet not updated...'],404);
            }
        }else{
            return response()->json(['message' => 'Wallet not found..'],404);
        }

    }

    // public function updateEwallet(Request $request, $userid){
    //     $ewalletId = DB::table('user')->select('walletID')->where('userID',$userid)->value('walletID');;
    //     $e_wallet = EWallet::find($ewalletId);

    //     if($e_wallet){
    //         return response()->json(['message'=>'E wallet balance updated...'],200);
    //     }else{
    //         return response()->json(['message'=>'E wallet not found...'],404);
    //     }
    // }
}
