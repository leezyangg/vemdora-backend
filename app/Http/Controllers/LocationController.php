<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\VendingMachine;

class LocationController extends Controller
{
    public function getLocationList(){
        try{
        // get all location from DB
        $locations = Location::all();

        return response()->json(['location' => $locations],200);
        }catch(Exception $e){
            return response()->json(['message' => 'something went wrong...','error' => $e->getMessage()], 400);
        }
    }

    public function showVendingMachine($locationID){
        try{
            //get vending machine that are located under one location
           $vending_machines = VendingMachine::where('locationID', $locationID)->get();
           return response()->json(['vendingMachines'=> $vending_machines],200);
        }catch(Exception $e){
           return response()->json(['message' => 'something went wrong...','error' => $e->getMessage()], 400);

    }
    }
}
