<?php

namespace Database\Seeders;

use App\Models\EWallet;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use File;
class EWalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database\data\wallet.json");
        $ewallets = json_decode($json);
        foreach($ewallets as $key => $value)
        {
            EWallet::create([
                "walletValue" => $value->walletValue
                
            ]);
        }
    }
}
