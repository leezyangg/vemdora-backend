<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'userID';

    protected $fillable = [
        'userName',
        'email',
        'password',
        'userType',
        'walletID',
        'companyName'
    ];
    public $timestamps = false;

}
