<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'alumnikarir@harkatnegeri.ac.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);
        Admin::create([
            'name' => 'Admin Prodi',
            'email' => 'prodi@harkatnegeri.ac.id',
            'password' => Hash::make('123456'),
            'role' => 'admin_prodi'
        ]);

    }

}
