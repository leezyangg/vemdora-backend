<?php

namespace App\Http\Controllers;

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
    public function registerVendingMachine(Request $request)
    {
        $product_items = $request['items'];
        $vending_machine = VendingMachine::create();
        foreach ($product_items as $item) {
            $itemId = $item['id'];
            $quantity = $item['quantity'];
        
            $vendingMachine->items()->attach($itemId, ['stockQuantity' => $quantity]);
        }
        

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vending_machine = VendingMachine::find($id);

        if ($vending_machine) {
            return response()->json($vending_machine);
        }
    
        return response()->json(['message' => 'Vending Machine not found'], 404);
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
