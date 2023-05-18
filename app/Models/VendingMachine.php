<?php

namespace App\Models;

use App\Models\ProductStock;
use Illuminate\Database\Eloquent\Model;
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
        return $this->belongsToMany(ProductStock::class,'product_vending_machine')->withPivot('stockQuantity');
    }
}
