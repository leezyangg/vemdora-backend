<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use File;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //User::truncate();
        $json = File::get("database\data\users.json");
        $users = json_decode($json);
        foreach($users as $key => $value)
        {
            User::create([
                "userName" => $value->userName,
                "companyName" => property_exists($value, 'companyName') ? $value->companyName : null,
                "email"=> $value->email,
                "password" => $value->password,
                "userType"=> $value->userType,
                "walletID"=> property_exists($value, 'walletID') ? $value->walletID : null,
            ]);
        }
    }
}
