<?php

namespace Database\Seeders;

use File;
use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database\data\locations.json");
        $locations = json_decode($json);
        foreach($locations as $key => $value)
        {
            Location::create([
                "locationName" => $value->locationName
                
            ]);
        }
    }
    
}
