<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MasterKelompokPangan;
use Illuminate\Support\Str;

class MasterKelompokPanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelompokList = [
            ['kode' => 'KP001', 'nama' => 'Serealia', 'keterangan' => 'Kelompok pangan serealia'],
            ['kode' => 'KP002', 'nama' => 'Umbi', 'keterangan' => 'Kelompok pangan umbi'],
            ['kode' => 'KP003', 'nama' => 'Kacang-Kacangan, Polong-Polongan, Biji-Bijian, dan Biji/Buah Berminyak', 'keterangan' => 'Kelompok kacang, polong, biji, buah berminyak'],
            ['kode' => 'KP004', 'nama' => 'Sayur, termasuk Jamur', 'keterangan' => 'Kelompok sayur dan jamur'],
            ['kode' => 'KP005', 'nama' => 'Buah', 'keterangan' => 'Kelompok buah'],
            ['kode' => 'KP006', 'nama' => 'Rempah', 'keterangan' => 'Kelompok rempah'],
            ['kode' => 'KP007', 'nama' => 'Bahan Penyegar dan Pemanis', 'keterangan' => 'Kelompok bahan penyegar dan pemanis'],
        ];

        foreach ($kelompokList as $kelompok) {
            \App\Models\MasterKelompokPangan::create([
                'id' => Str::uuid(),
                'kode_kelompok_pangan' => $kelompok['kode'],
                'nama_kelompok_pangan' => $kelompok['nama'],
                'keterangan' => $kelompok['keterangan'],
                'is_active' => true,
                'created_by' => 'seeder',
            ]);
        }
    }
}
