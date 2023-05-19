<?php

namespace Database\Seeders;

use File;
use App\Models\StockType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StockTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database\data\stocktype.json");
        $stocktype = json_decode($json);
        foreach($stocktype as $key => $value)
        {
            StockType::create([
                "level" => $value->level,
                "stockType" => $value->stockType
                
            ]);
        }
    }
}
