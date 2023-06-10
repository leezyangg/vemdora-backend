<?php

namespace Database\Seeders;

use File;
use App\Models\ProductStock;
use App\Models\VendingMachine;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
            $vending_machine = VendingMachine::findOrFail($value->vendingMachineID);
            //search for the product
            $items = ProductStock::where('stockName', $value->stockName)->first();
            //search for the supplier for the product
            $supplierID = DB::table('user')
                ->where('userName', $value->supplierName)
                ->where('userType', 'Supplier')
                ->value('userID');
            
            if(!$items){
                $product_stock = ProductStock::create([
                    
                    'supplierID' => $supplierID,
                    'stockName'=> $value->stockName,
                    'level'=>$value->level,
                    'buyPrice'=>$value->buyPrice,
                    'sellPrice'=>$value->sellPrice,
                    'imageURL'=>$value->imageURL
                
            ]);
            $vending_machine->productItems()->attach($product_stock->stockID, ['stockQuantity' => $value->stockQuantity]);

        }else{
            $vending_machine->productItems()->attach($product->stockID, ['stockQuantity' => $value->stockQuantity]);

        }
        }
    }
}
