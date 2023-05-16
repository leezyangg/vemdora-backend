<?php

namespace App\Models;

use App\Models\VendingMachine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductStock extends Model
{
    use HasFactory;
    protected $table = 'product_stock';

    public function vendingMachine():BelongsToMany
    {
        return $this->belongsToMany(ProductStock::class,'product_vending_machine')->withPivot('stockQuantity');
    }
}
