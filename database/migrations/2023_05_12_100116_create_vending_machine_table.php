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
        Schema::create('vending_machine', function (Blueprint $table) {
            $table->id('vendingMachineID');
            $table->string('vendingMachineName')->nullable();
            $table->foreignId('locationID')->constrained('location','locationID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vending_machine');
    }
};
