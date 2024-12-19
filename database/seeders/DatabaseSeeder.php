<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Pimpinan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'username' => 'admin',
            'password' => Hash::make('1'), 
        ]);

        Pimpinan::create([
            'password' => Hash::make('2'), 
            'nama_pimpinan' => '2',
        ]);
    }
}

