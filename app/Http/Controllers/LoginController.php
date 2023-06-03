<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\User;
use App\Models\EWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function verifyUser(Request $req){
        try{
        $input_email = $req->email;
        $input_password = $req->password;
        
        // search the user base on email from DB
        $user = User::where('email', $input_email)->first();
        
        // if the user is found and the password is matched
        if($user && $user->password ==  $input_password){
            //if (Hash::check($password, $user->password)) {
                // User credentials are valid
                 // Generate a session ID
                $sessionId = uniqid();

        // Store the session ID in Laravel's session
                Session::put('session_id', $sessionId);
                return response()->json(['message' => 'Credentials are valid','userType'=> $user->userType,'session_id' => $sessionId],
                 200);
           // }
       }else{
        return response()->json(['message' => 'Invalid credentials'], 401);
       }
    }catch(Exception $e){
        return response()->json(['message' => 'something went wrong...','error' => $e->getMessage()], 400);

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
        try{
        //create a new ewallet for the new user
        $new_wallet = EWallet::create([
            "walletValue" => 0
            
        ]);
        error_log('New wallet created: ' . json_encode($new_wallet));

        //store the new user record into db
        $new_user = User::create([
            "userName" => $req->userName,
            'email'=>$req->email,
            'password'=> $req->password,
            'userType'=>'Public User',
            'walletID' => $new_wallet->walletID
        ]);
        if($new_user){
            return response()->json(['message' => 'user sign up successfully!'],200);
        }else{
            return response()->json(['message' => 'something went wrong!'],404);
        }

        error_log('New user created: ' . json_encode($new_user));
    }catch(Exception $e){
        return response()->json(['message' => 'something went wrong...','error' => $e->getMessage()], 400);

    }

    }
}