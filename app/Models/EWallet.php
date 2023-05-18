<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EWallet extends Model
{
    use HasFactory;
    protected $table = 'e_wallet';
    protected $primaryKey = 'walletID';
    protected $fillable = [
        'walletValue',
        
    ];
    public $timestamps = false;

}
