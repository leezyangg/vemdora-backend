<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use File;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database\data\transaction.json");
        $transactions = json_decode($json);
        foreach($transactions as $key => $value)
        {
            Transaction::create([
                "transactionDate" => $value->transactionDate,
                "transactionAmount"=> $value->transactionAmount
               
            ]);
        }
    }
}
