<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\VendingMachine;

class LocationController extends Controller
{
    public function getLocationList(){
        $locations = Location::all();

        return response()->json(['location' => $locations],200);
    }

    public function showVendingMachine($locationID){
        $vending_machines = VendingMachine::where('locationID', $locationID)->get();
        return response()->json(['vendingMachines'=> $vending_machines],200);
    }
}
