<?php

namespace App\Models;

use App\Models\Order;
use App\Models\VendingMachine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductStock extends Model
{
    use HasFactory;
    protected $table = 'product_stock';
    protected $primaryKey = 'stockID';
    public $timestamps = false;
    protected $fillable = [
        'supplierID','stockName','level','buyPrice','sellPrice','stockQuantity','imageURL'
    ];
    public function vendingMachine():BelongsToMany
    {
        return $this->belongsToMany(ProductStock::class,'product_vending_machine','vendingMachineID','stockID')->withPivot('stockQuantity');
    }

    public function order():BelongsToMany
    {
        return $this->belongsToMany(Order::class,'order_product','orderID','stockID')->withPivot('orderedQuantity');
    }
}
