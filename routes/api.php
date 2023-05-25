<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EwalletController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
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
Route::get('suppliers',[SupplierController::class,'getSupplierList']);
Route::post('suppliers/register',[SupplierController::class,'registerSupplier']);
Route::post('suppliers/update/{vendingMachineID}',[SupplierController::class,'updateStock']);
Route::post('vendingMachines',[VendingMachineController::class,'registerVendingMachine']);
Route::get('vendingMachines',[VendingMachineController::class,'getVendingMachines']);
Route::get('vendingMachines/{vendingMachineID}',[VendingMachineController::class,'show']);
Route::delete('vendingMachines/{vendingMachineID}/delete',[VendingMachineController::class,'deleteVendingMachine']);
Route::get('vendingMachines/{vendingMachineID}/items',[VendingMachineController::class,'getItems']);
Route::post('vendingMachines/{vendingMachineID}/items',[VendingMachineController::class,'addItems']);
Route::post('orders/{vendingMachineID}/{userID}',[OrderController::class,'placeOrder']);
Route::post('orders/calculatePrice',[OrderController::class,'calculateTotalPrice']);
Route::get('ewallets/{userID}',[EwalletController::class,'getEwallet']);
Route::post('ewallets/{userID}',[EwalletController::class,'topUp']);
Route::get('dashboard/topProducts',[DashboardController::class,'getTopProducts']);
Route::get('dashboard/topVendingMachines',[DashboardController::class,'getTopVendingMachines']);

