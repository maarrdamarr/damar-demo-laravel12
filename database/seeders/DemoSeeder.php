<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Program;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\StudentProfile;
use App\Models\LecturerProfile;
use App\Models\Invoice;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // pastikan program ada
        $ti = Program::firstOrCreate(
            ['code' => 'TI-UNESA-25'],
            ['name' => 'Teknik Informatika']
        );

        // users per role
        $mhs = User::firstOrCreate(
            ['email' => 'mhs@dclass.test'],
            ['name' => 'Mahasiswa Demo', 'password' => bcrypt('password')]
        ); $mhs->assignRole('mahasiswa');

        $dsn = User::firstOrCreate(
            ['email' => 'dosen@dclass.test'],
            ['name' => 'Dosen Demo', 'password' => bcrypt('password')]
        ); $dsn->assignRole('dosen');

        $opr = User::firstOrCreate(
            ['email' => 'operator@dclass.test'],
            ['name' => 'Operator Demo', 'password' => bcrypt('password')]
        ); $opr->assignRole('operator');

        $keu = User::firstOrCreate(
            ['email' => 'keuangan@dclass.test'],
            ['name' => 'Keuangan Demo', 'password' => bcrypt('password')]
        ); $keu->assignRole('keuangan');

        // profiles
        StudentProfile::firstOrCreate([
            'user_id' => $mhs->id
        ], [
            'nim' => '2200001',
            'program_id' => $ti->id,
            'semester' => 3
        ]);

        LecturerProfile::firstOrCreate([
            'user_id' => $dsn->id
        ], [
            'nidn' => '1100110011',
            'program_id' => $ti->id
        ]);

        // courses & classes
        $if101 = Course::firstOrCreate(
            ['code'=>'IF101'],
            ['name'=>'Algoritma & Pemrograman', 'credits'=>3, 'program_id'=>$ti->id]
        );
        $if102 = Course::firstOrCreate(
            ['code'=>'IF102'],
            ['name'=>'Struktur Data', 'credits'=>3, 'program_id'=>$ti->id]
        );

        CourseClass::firstOrCreate(
            ['course_id'=>$if101->id, 'class_code'=>'A'],
            ['lecturer_id'=>$dsn->id, 'quota'=>40, 'room'=>'R101', 'day'=>'Senin', 'time'=>'08:00-09:40']
        );
        CourseClass::firstOrCreate(
            ['course_id'=>$if102->id, 'class_code'=>'A'],
            ['lecturer_id'=>$dsn->id, 'quota'=>40, 'room'=>'R102', 'day'=>'Rabu', 'time'=>'10:00-11:40']
        );

        // invoice contoh
        Invoice::firstOrCreate(
            ['number' => 'INV-DEMO-001'],
            ['student_id'=>$mhs->id, 'amount'=>2500000, 'status'=>'unpaid']
        );
    }
}
