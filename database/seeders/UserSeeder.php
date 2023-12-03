<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\BusinessSettings;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $business = BusinessSettings::create([
            'business_name' => 'New Business',
            'business_email' => 'admin@gmail.com',
        ]);
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password'=>Hash::make('12345678'),
            'business_id'=>$business->id
        ]);
    }
}
