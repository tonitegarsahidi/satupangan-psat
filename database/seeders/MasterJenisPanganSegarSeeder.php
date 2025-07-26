<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterKelompokPangan;
use Illuminate\Support\Str;

class MasterJenisPanganSegarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mapping kelompok kode ke id
        $kelompokMap = MasterKelompokPangan::pluck('id', 'nama_kelompok_pangan')->toArray();

        $jenisList = [
            // Serealia
            ['kode' => 'JP001', 'nama' => 'Serealia', 'kelompok' => 'Serealia'],
            // Umbi
            ['kode' => 'JP002', 'nama' => 'Umbi', 'kelompok' => 'Umbi'],
            // Kacang-Kacangan, Polong-Polongan, Biji-Bijian, dan Biji/Buah Berminyak
            ['kode' => 'JP003', 'nama' => 'Kacang-Kacangan', 'kelompok' => 'Kacang-Kacangan, Polong-Polongan, Biji-Bijian, dan Biji/Buah Berminyak'],
            ['kode' => 'JP004', 'nama' => 'Polong-Polongan', 'kelompok' => 'Kacang-Kacangan, Polong-Polongan, Biji-Bijian, dan Biji/Buah Berminyak'],
            // Sayur, termasuk Jamur (dikelompokkan dan diseragamkan)
            ['kode' => 'JP005', 'nama' => 'Sayuran Kubis-Kubisan', 'kelompok' => 'Sayur, termasuk Jamur'],
            ['kode' => 'JP006', 'nama' => 'Sayuran Umbi Lapis', 'kelompok' => 'Sayur, termasuk Jamur'],
            ['kode' => 'JP007', 'nama' => 'Sayuran Buah', 'kelompok' => 'Sayur, termasuk Jamur'],
            ['kode' => 'JP008', 'nama' => 'Sayuran Daun', 'kelompok' => 'Sayur, termasuk Jamur'],
            ['kode' => 'JP009', 'nama' => 'Sayuran Umbi dan Akar', 'kelompok' => 'Sayur, termasuk Jamur'],
            ['kode' => 'JP010', 'nama' => 'Sayuran Batang dan Tangkai', 'kelompok' => 'Sayur, termasuk Jamur'],
            ['kode' => 'JP012', 'nama' => 'Sayuran Bunga', 'kelompok' => 'Sayur, termasuk Jamur'],
            // Buah
            ['kode' => 'JP013', 'nama' => 'Buah Kulit Tidak Dimakan', 'kelompok' => 'Buah'],
            ['kode' => 'JP014', 'nama' => 'Buah Beri dan Kecil Lainnya', 'kelompok' => 'Buah'],
            ['kode' => 'JP015', 'nama' => 'Buah Jeruk (Citrus)', 'kelompok' => 'Buah'],
            ['kode' => 'JP016', 'nama' => 'Buah Pome', 'kelompok' => 'Buah'],
            ['kode' => 'JP017', 'nama' => 'Buah Batu (Stone Fruits)', 'kelompok' => 'Buah'],
            // Rempah
            ['kode' => 'JP018', 'nama' => 'Rempah (Buah, Bunga, Batang, Rimpang, Biji)', 'kelompok' => 'Rempah'],
            // Bahan Penyegar dan Pemanis
            ['kode' => 'JP019', 'nama' => 'Bahan Penyegar dan Pemanis', 'kelompok' => 'Bahan Penyegar dan Pemanis'],
        ];

        foreach ($jenisList as $jenis) {
            MasterJenisPanganSegar::create([
                'id' => Str::uuid(),
                'kelompok_id' => $kelompokMap[$jenis['kelompok']],
                'kode_jenis_pangan_segar' => $jenis['kode'],
                'nama_jenis_pangan_segar' => $jenis['nama'],
                'is_active' => true,
                'created_by' => 'seeder',
            ]);
        }
    }
}
