<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //generate 10 mahasiswa from factory
        Mahasiswa::factory()->count(10)->create();
        //create one mahasiswa with array
        Mahasiswa::create([
            'nama' => 'Rizky',
            'nim' => '1234567891',
            'email' => 'rizky@gmail.com',
            'jurusan' => 'Teknik Informatika',
            'nomor_handphone' => '081234567890',
            'alamat' => 'Jl. Raya Cibubur No. 1',
        ]);
    }
}
