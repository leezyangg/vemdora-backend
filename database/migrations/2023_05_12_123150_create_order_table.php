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
        Schema::create('order', function (Blueprint $table) {
            $table->id('orderID');
            //$table->foreignId('stockID')->constrained('product_stock','stockID');
            $table->foreignId('publicID')->constrained('user','userID');
            $table->foreignId('vendingMachineID')->constrained('vending_machine','vendingMachineID');
            $table->foreignId('transactionID')->constrained('transaction','transactionID');

            //$table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
