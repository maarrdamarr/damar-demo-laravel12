<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Program;

class StarterSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['admin','mahasiswa','dosen','operator','keuangan'] as $r) {
            Role::findOrCreate($r,'web');
        }

        $admin = User::firstOrCreate(
            ['email' => 'admin@dclass.test'],
            ['name' => 'Super Admin', 'password' => bcrypt('password')]
        );
        $admin->assignRole('admin');

        // contoh prodi
        Program::firstOrCreate(['code' => 'TI-UNESA-25'], ['name' => 'Teknik Informatika']);
    }
}