<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Location;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Models\VendingMachine;
use Illuminate\Support\Facades\DB;

class VendingMachineController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function getVendingMachines()
    {
        try{
        $vending_machine = VendingMachine::all();
        return response()->json($vending_machine);
        }catch(Exception $e){
            return response()->json(['message' => 'something went wrong...','error' => $e->getMessage()], 400);

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function registerVendingMachine(Request $req)
    {
        //get all the items in an array
        //$product_items = $req->items;
        // find in database whether the location exist
        $location = Location::firstOrCreate(['locationName' => $req->locationName]);
        
        //register new vending machine
        $vending_machine = VendingMachine::create([
            "vendingMachineName" => $req->vendingMachineName,
            "locationID" =>  $location->locationID
        ]);
        //attach the corresponding product stock item to pivot table
        // foreach ($product_items as $item) {
        //     $itemId = $item['stockID'];
        //     $quantity = $item['stockQuantity'];
        
        //     $vending_machine->productItems()->attach($itemId, ['stockQuantity' => $quantity]);
        // }
        
        if ($vending_machine) {
            return response()->json(['message' => 'Vending Machine is registered'], 200);
        }else{
            return response()->json(['message' => 'Vending Machine not found'], 404);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
        $vending_machine = VendingMachine::find($id);

        if ($vending_machine) {
            return response()->json($vending_machine);
        }else{
            return response()->json(['message' => 'Vending Machine not found'], 404);

        }
    }catch(Exception $e){
        return response()->json(['message' => 'something went wrong...','error' => $e->getMessage()], 400);

    }
    
    }

    public function addItems(Request $req,$vendingMachineID){
        //find the vending machine
        try {
        $vending_machine = VendingMachine::findOrFail($vendingMachineID);
        $product_items = $req->items;
         foreach ($product_items as $item) {
           //search for the product
            $product = ProductStock::where('stockName', $item['stockName'])->first();
            //search for the supplier for the product
            $supplierID = DB::table('user')
                ->where('userName', $item['supplierName'])
                ->where('userType', 'Supplier')
                ->value('userID');
            //create a new product if it is a new record
            if(!$product){
                $product_stock = ProductStock::create([
                    'supplierID' => $supplierID,
                    'stockName'=> $item['stockName'],
                    'level'=>$item['level'],
                    'buyPrice'=>$item['buyPrice'],
                    'sellPrice'=>$item['sellPrice'],
                    'imgaeURL'=>$item['imageURL']
                    
                ]);
                error_log('New item created: ' . json_encode($product_stock));
            //attach the quantity of product in pivot table
            $vending_machine->productItems()->attach($product_stock->stockID, ['stockQuantity' => $item['stockQuantity']]);
           
            }else{
                $vending_machine->productItems()->attach($product->stockID, ['stockQuantity' => $item['stockQuantity']]);
            }
        }
                    return response()->json(['message'=> 'Item added successfully!'],200);
    }catch(Exception $e){
        return response()->json(['message' => 'something went wrong...','error' => $e->getMessage()], 400);

    }

    }

    public function getItems($vendingMachineID){
        try{
        $vendingMachine = VendingMachine::find($vendingMachineID);

         if (!$vendingMachine) {
            return response()->json(['message' => 'Vending machine not found'], 404);
        }

         $items = $vendingMachine->productItems()->get();

        return response()->json(['items' => $items], 200);
    }catch(Exception $e){
        return response()->json(['message' => 'something went wrong...','error' => $e->getMessage()], 400);

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
    public function deleteVendingMachine($vendingMachineID)
    {
        try{
        $vending_machine = VendingMachine::find($vendingMachineID);

        if($vending_machine){
            $vending_machine->delete();
            return response()->json(['message'=> 'Vending machine deleted successfully!'],200);
        }else{
            return response()->json(['message'=> 'Something went wrong!'],404);
        }
    }catch(Exception $e){
        return response()->json(['message' => 'something went wrong...','error' => $e->getMessage()], 400);

    }
    }
}
