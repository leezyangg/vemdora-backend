<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EwalletController;
use App\Http\Controllers\LocationController;
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

//sign up, create a new user record
Route::post('users',[LoginController::class,'signUp']);
//verify user, get the user based on the email and password
Route::get('users',[LoginController::class,'verifyUser']);
//get a list of suppliers
Route::get('suppliers',[SupplierController::class,'getSupplierList']);
//register suppliers
Route::post('suppliers/register',[SupplierController::class,'registerSupplier']);
//update stock
Route::post('suppliers/update/{vendingMachineID}',[SupplierController::class,'updateStock']);
//send notification
Route::get('suppliers/alerts',[SupplierController::class,'sendNotification']);
//register vending machine
Route::post('vendingMachines',[VendingMachineController::class,'registerVendingMachine']);
//retrive a list of vending machine
Route::get('vendingMachines',[VendingMachineController::class,'getVendingMachines']);
//retrive a single vending machine base on id
Route::get('vendingMachines/{vendingMachineID}',[VendingMachineController::class,'show']);
//get Stock type and level
Route::get('stocktype',[VendingMachineController::class,'getStockType']);
//delete a vending machine base on id
Route::delete('vendingMachines/{vendingMachineID}/delete',[VendingMachineController::class,'deleteVendingMachine']);
//retrive a list of available items in a vending machine
Route::get('vendingMachines/{vendingMachineID}/items',[VendingMachineController::class,'getItems']);
//add items into a vending machine
Route::post('vendingMachines/{vendingMachineID}/items',[VendingMachineController::class,'addItems']);
//place an order
Route::post('orders/{vendingMachineID}/{userID}',[OrderController::class,'placeOrder']);
//calculate total price of the order
Route::post('orders/calculatePrice',[OrderController::class,'calculateTotalPrice']);
//get mock sales data
Route::get('orders/sales',[OrderController::class,'getSales']);
//get ewallet of a user
Route::get('ewallets/{userID}',[EwalletController::class,'getEwallet']);
//top up ewallet
Route::post('ewallets/{userID}',[EwalletController::class,'topUp']);
//retrive the top 5 products
Route::get('dashboard/topProducts',[DashboardController::class,'getTopProducts']);
//retrive the top 5 vending machine
Route::get('dashboard/topVendingMachines',[DashboardController::class,'getTopVendingMachines']);
//retrive review of dashboard
Route::get('dashboard/review',[DashboardController::class,'getReview']);
//retrive the details of one vending machine
Route::get('dashboard/{vendingMachineID}/details',[DashboardController::class,'getVmMapDetails']);
//retrive a list of location
Route::get('location',[LocationController::class,'getLocationList']);
//show nearby vending machine base on location
Route::get('location/{locationID}',[LocationController::class,'showVendingMachine']);

