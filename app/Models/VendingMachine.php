<?php

namespace App\Models;

use App\Models\StockType;
use App\Models\ProductStock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class VendingMachine extends Model
{
    use HasFactory;
    protected $table = 'vending_machine';
    protected $primaryKey = 'vendingMachineID';

    protected $fillable = [ 
        'vendingMachineName','locationID'
    ];
    public $timestamps = false;

    public function productItems():BelongsToMany{
        return $this->belongsToMany(ProductStock::class,'product_vending_machine','vendingMachineID','stockID')->withPivot('stockQuantity');
    }

    public function productType(): HasMany
{
    return $this->hasMany(StockType::class,'type_vending_machine');
}

}
