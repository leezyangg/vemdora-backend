<?php

namespace App\Models;

use App\Models\ProductStock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';
    protected $primaryKey = 'orderID';

    
    public function productItems():BelongsToMany{
        return $this->belongsToMany(ProductStock::class,'order_product','orderID','stockID')->withPivot('orderedQuantity');
    }

}
