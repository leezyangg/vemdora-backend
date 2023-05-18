<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Models\VendingMachine;

class VendingMachineController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vending_machine = VendingMachine::all();
        return response()->json($vending_machine);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function registerVendingMachine(Request $req)
    {
        //get all the items in an array
        $product_items = $request['items'];
        // find in database whether the location exist
        $location = Location::where('locationName',$req->locationID)->first();
       
        if($location) {
            $locationId = $location->locationID;
        }else{
              //if not exist create a new location
              $new_location = Location::create(["locationName"=> $req->locationName]);
              $locationId = $new_location->locationID;
         }
           
        //register new vending machine
        $vending_machine = VendingMachine::create([
            "vendingMachineName" => $req->vendingMachineName,
            "locationID" =>  $locationId
        ]);
        //attach the corresponding product stock item to pivot table
        foreach ($product_items as $item) {
            $itemId = $item['stockID'];
            $quantity = $item['stockQuantity'];
        
            $vendingMachine->items()->attach($itemId, ['stockQuantity' => $quantity]);
        }
        

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $vending_machine = VendingMachine::find($id);

        if ($vending_machine) {
            return response()->json($vending_machine);
        }else{
            return response()->json(['message' => 'Vending Machine not found'], 404);

        }
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vending_machine = VendingMachine::find($id);

        if($vending_machine){
            $vending_machine->delete();
            return response()->json(['message'=> 'Vending machine deleted successfully!'],200);
        }else{
            return response()->json(['message'=> 'Something went wrong!'],404);
        }
    }
}
