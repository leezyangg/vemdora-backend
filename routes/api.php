<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EwalletController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\VendingMachineController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Route::get('orders',[OrderController::class,'index']);
Route::post('users',[LoginController::class,'signUp']);
Route::get('users',[LoginController::class,'verifyUser']);
Route::post('suppliers',[SupplierController::class,'registerSupplier']);
Route::post('vendingMachines',[VendingMachineController::class,'registerVendingMachine']);
Route::get('vendingMachines',[VendingMachineController::class,'getVendingMachines']);
Route::get('vendingMachines/{vendingMachineID}',[VendingMachineController::class,'show']);
Route::delete('vendingMachines/{vendingMachineID}/delete',[VendingMachineController::class,'deleteVendingMachine']);
Route::get('vendingMachines/{vendingMachineID}/items',[VendingMachineController::class,'getItems']);
Route::post('vendingMachines/{vendingMachineID}/items',[VendingMachineController::class,'addItems']);
Route::get('ewallets/{userID}',[EwalletController::class,'getEwallet']);

