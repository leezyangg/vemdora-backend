<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\EWalletSeeder;
use Database\Seeders\LocationSeeder;
use Database\Seeders\StockTypeSeeder;
use Database\Seeders\VendingMachineSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            EWalletSeeder::class,
            UserSeeder::class,
            StockTypeSeeder::class,
            LocationSeeder::class,
            VendingMachineSeeder::class,
            ProductStockSeeder::class

        ]);
    }
}
