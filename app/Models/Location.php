<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $table = 'location';
    protected $primaryKey = 'locationID';

    protected $fillable = [ 
        'locationName','latitude','longitude'
    ];
    public $timestamps = false;
}
