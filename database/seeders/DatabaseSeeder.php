<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'HRD',
            'username' => 'hrd',
            'password' => bcrypt('hrd'),
            'role' => 'HRD'
        ]);
        User::create([
            'name' => 'Pegawai',
            'username' => 'pegawai',
            'password' => bcrypt('pegawai'),
            'role' => 'Pegawai'
        ]);
        User::create([
            'name' => 'Direktur',
            'username' => 'direktur',
            'password' => bcrypt('direktur'),
            'role' => 'Direktur'
        ]);
    }
}
