<?php

namespace Database\Seeders;

use App\Models\Lokasi;
use App\Models\Admin;
use App\Models\Login;
use App\Models\Petugas;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        Lokasi::create([
            'nama_lokasi' => 'VIKTOR',
        ]);

        Lokasi::create([
            'nama_lokasi' => 'SUTOMO',
        ]);

        Login::create([
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'roles' => 'admin',
            'is_active' => true,
        ]);
        
        Admin::create([
            'nama_lengkap' => 'Admin',
            'login_id' => 1,
            'lokasi_id' => 2,
            'nip' => '182011022201',
            'no_hp' => '0897129202100',
            'jenis_kelamin' => 'Laki-Laki'
        ]);

        Login::create([
            'email' => 'operator@gmail.com',
            'password' => bcrypt('operator123'),
            'roles' => 'operator',
            'is_active' => true,
        ]);

        Petugas::create([
            'nama_lengkap' => 'Operator',
            'login_id' => 2,
            'lokasi_id' => 1,
            'nip' => '182011022201',
            'no_hp' => '0897129202100',
            'jenis_kelamin' => 'Laki-Laki'
        ]);


        // Petugas::create([
        //     'nama_lengkap' => 'Petugas',
        //     'email' => 'petugas@gmail.com',
        //     'password' => bcrypt('petugas123'),
        //     'lokasi_id' => 1,
        //     'nip' => '182011022201',
        //     'no_hp' => '0897129202100',
        //     'jenis_kelamin' => 'Laki-Laki',
        //     'status_petugas' => true,
        // ]);
    }
}
