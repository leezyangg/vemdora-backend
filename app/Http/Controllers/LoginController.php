<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\EWallet;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function verifyUser(Request $req){
        $input_email = $req->email;
        $input_password = $req->password;
        
        $user = User::where('email', $input_email)->first();
        
        if($user && $user->password ==  $input_password){
            //if (Hash::check($password, $user->password)) {
                // User credentials are valid
                return response()->json(['message' => 'Credentials are valid','userType'=> $user->userType],
                 200);
           // }
       }else{
        return response()->json(['message' => 'Invalid credentials'], 401);
       }
   }


//    public function checkUserType($email){
//     $user = User::where('email', $email)->first();

//         if ($user) {
//             return $user->userType;
//         }else{
//             return null;
//         }
//    }

    public function signUp(Request $req){
        $new_wallet = EWallet::create([
            "walletValue" => 0
            
        ]);
        error_log('New wallet created: ' . json_encode($new_wallet));

        $new_user = User::create([
            'userName' => $req->userName,
            'email'=>$req->email,
            'password'=> $req->password,
            'userType'=>$req->userType,
            'walletID' => $new_wallet->walletID
        ]);
        if($new_user){
            return response()->json(['message' => 'user sign up successfully!'],200);
        }else{
            return response()->json(['message' => 'something went wrong!'],404);
        }

        error_log('New user created: ' . json_encode($new_user));

    }
}