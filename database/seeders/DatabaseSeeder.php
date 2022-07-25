<?php

namespace Database\Seeders;

use App\Models\Lokasi;
use App\Models\Admin;
use App\Models\User;
use App\Models\Login;
use App\Models\MasterStatus;
use App\Models\Petugas;
use App\Models\Plts;
use App\Models\Status;
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
        MasterStatus::create([
            'nama_status' => 'Belum Terbayar',
        ]);
        MasterStatus::create([
            'nama_status' => 'Menunggu Konfirmasi',
        ]);
        MasterStatus::create([
            'nama_status' => 'Terbayar',
        ]);
        MasterStatus::create([
            'nama_status' => 'Di Batalkan',
        ]);
        MasterStatus::create([
            'nama_status' => 'Berhenti',
        ]);

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

        Login::create([
            'email' => 'juminten@gmail.com',
            'password' => bcrypt('juminten123'),
            'roles' => 'user',
            'is_active' => true,
        ]);

        User::create([
            'nama_lengkap' => 'juminten',
            'login_id' => 3,
            'lokasi_id' => 1,
            'nik' => '3174109020120001',
            'no_hp' => '085778992100',
            'jenis_kelamin' => 'Perempuan',
            'rekening' => '99210020011'
        ]);

        Login::create([
            'email' => 'plts@gmail.com',
            'password' => bcrypt('plts123'),
            'roles' => 'plts',
            'is_active' => true,
        ]);

        Plts::create([
            'nama_lengkap' => 'plts',
            'login_id' => 4,
            'lokasi_id' => 1,
            'nip' => '182011022201',
            'no_hp' => '0897129202100',
            'jenis_kelamin' => 'Laki-Laki'
        ]);
    }
}
