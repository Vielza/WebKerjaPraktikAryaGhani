<?php
// filepath: c:\laragon\www\wep_Kape\database\seeders\AdminSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678'), 
            'phone' => '081234567890',
            'address' => 'Jl. Admin No. 1',
            'role' => 'admin', 
        ]);
    }
}
