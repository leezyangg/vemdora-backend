<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transaction';
    protected $primaryKey = 'transactionID';
    public $timestamps = false;
    protected $fillable = [
        'transactionDate','transactionAmount'
    ];
}
