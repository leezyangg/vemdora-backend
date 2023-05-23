<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('type_vending_machine', function (Blueprint $table) {
            //$table->foreignId('stockID')->constrained('product_stock','stockID');
            $table->foreignId('vendingMachineID')->constrained('vending_machine','vendingMachineID');
            $table->foreignId('level')->constrained('stock_type','level');
            $table->integer('stockQuantity');
            //$table->primary(['stockID', 'vendingMachineID','supplierID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
