<?php

namespace Database\Seeders;

use File;
use App\Models\ProductStock;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database\data\product.json");
        $product = json_decode($json);
        foreach($product as $key => $value)
        {
            ProductStock::create([
                'stockName'=> $value->stockName,
                'level'=>$value->level,
                'sellPrice' => $value->sellPrice,
                'stockQuantity'=> $value->stockQuantity
                
            ]);
        }
    }
}
