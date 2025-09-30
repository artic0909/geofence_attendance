<?php
namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void {
        Admin::create([
            'name' => 'Palgeo Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}