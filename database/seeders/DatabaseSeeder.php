<?php

namespace Database\Seeders;

use App\Models\Pimpinan;
use App\Models\Admin;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

    Admin::factory()->create([
            'id_admin' => '1',
            'username' => '1',
            'password' => '1',
    ]);

    Pimpinan::factory()->create([
            'id_pimpinan' => '2',
            'password' => '2',
            'nama_pimpinan' => '2',
    ]);

    }
}
