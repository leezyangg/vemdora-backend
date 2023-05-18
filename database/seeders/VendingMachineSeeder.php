<?php

namespace Database\Seeders;

use App\Models\VendingMachine;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VendingMachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database\data\vendingMachines.json");
        $vending_machines = json_decode($json);
        foreach($vending_machines as $key => $value)
        {
            VendingMachine::create([
                "locationName" => $value->locationName,
                "vendingMachineName"=>$value->vendingMachineName
                
            ]);
        }
    }
}
