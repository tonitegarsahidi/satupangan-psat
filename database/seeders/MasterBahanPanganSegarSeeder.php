<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MasterBahanPanganSegar;
use App\Models\MasterJenisPanganSegar;
use Illuminate\Support\Str;

class MasterBahanPanganSegarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mapping kode jenis ke id
        $jenisMap = MasterJenisPanganSegar::pluck('id', 'kode_jenis_pangan_segar')->toArray();

        $bahanList = [
            // Serealia
            ['kode' => 'BP001', 'nama' => 'Beras', 'jenis' => 'JP001'],
            ['kode' => 'BP002', 'nama' => 'Jagung', 'jenis' => 'JP001'],
            ['kode' => 'BP003', 'nama' => 'Jagung Manis', 'jenis' => 'JP001'],
            ['kode' => 'BP004', 'nama' => 'Gandum', 'jenis' => 'JP001'],
            ['kode' => 'BP005', 'nama' => 'Sorgum', 'jenis' => 'JP001'],
            ['kode' => 'BP006', 'nama' => 'Rye', 'jenis' => 'JP001'],
            // Umbi
            ['kode' => 'BP007', 'nama' => 'Ubi Jalar', 'jenis' => 'JP002'],
            ['kode' => 'BP008', 'nama' => 'Uwi/Gadung/Gembili /Yam', 'jenis' => 'JP002'],
            // Kacang-Kacangan, Polong-Polongan, Biji-Bijian, dan Biji/Buah Berminyak
            ['kode' => 'BP009', 'nama' => 'Kacang-Kacangan Laimnya Pistachio', 'jenis' => 'JP003'],
            ['kode' => 'BP010', 'nama' => 'Kedelai', 'jenis' => 'JP004'],
            ['kode' => 'BP011', 'nama' => 'Dry Bean(1)', 'jenis' => 'JP004'],
            ['kode' => 'BP012', 'nama' => 'Kacang Tanah', 'jenis' => 'JP004'],
            // Sayur, termasuk Jamur
            // Sayuran Kubis-Kubisan
            ['kode' => 'BP013', 'nama' => 'Brokoli', 'jenis' => 'JP005'],
            ['kode' => 'BP014', 'nama' => 'Kembang Kol', 'jenis' => 'JP005'],
            ['kode' => 'BP015', 'nama' => 'Kailan', 'jenis' => 'JP005'],
            ['kode' => 'BP016', 'nama' => 'Kubis', 'jenis' => 'JP005'],
            // Sayuran Umbi Lapis
            ['kode' => 'BP017', 'nama' => 'Bawang Daun', 'jenis' => 'JP006'],
            ['kode' => 'BP018', 'nama' => 'Bawang Putih', 'jenis' => 'JP006'],
            ['kode' => 'BP019', 'nama' => 'Bawang Bombay', 'jenis' => 'JP006'],
            ['kode' => 'BP020', 'nama' => 'Bawang Merah', 'jenis' => 'JP006'],
            ['kode' => 'BP021', 'nama' => 'Kucai', 'jenis' => 'JP006'],
            // Sayuran Buah
            ['kode' => 'BP022', 'nama' => 'Waluh', 'jenis' => 'JP007'],
            ['kode' => 'BP023', 'nama' => 'Mentimun', 'jenis' => 'JP007'],
            ['kode' => 'BP024', 'nama' => 'Terung', 'jenis' => 'JP007'],
            ['kode' => 'BP025', 'nama' => 'Tomat', 'jenis' => 'JP007'],
            ['kode' => 'BP026', 'nama' => 'Paprika', 'jenis' => 'JP007'],
            ['kode' => 'BP027', 'nama' => 'Pare', 'jenis' => 'JP007'],
            ['kode' => 'BP028', 'nama' => 'Labu Siam', 'jenis' => 'JP007'],
            ['kode' => 'BP029', 'nama' => 'Gambas', 'jenis' => 'JP007'],
            ['kode' => 'BP030', 'nama' => 'Kacang Panjang', 'jenis' => 'JP007'],
            ['kode' => 'BP031', 'nama' => 'Cabai', 'jenis' => 'JP007'],
            // Sayuran Daun
            ['kode' => 'BP032', 'nama' => 'Selada', 'jenis' => 'JP008'],
            ['kode' => 'BP033', 'nama' => 'Bayam', 'jenis' => 'JP008'],
            ['kode' => 'BP034', 'nama' => 'Sawi', 'jenis' => 'JP008'],
            // Sayuran Umbi dan Akar
            ['kode' => 'BP035', 'nama' => 'Kentang', 'jenis' => 'JP009'],
            // Sayuran Batang dan Tangkai
            ['kode' => 'BP036', 'nama' => 'Seledri', 'jenis' => 'JP010'],
            // Sayuran Bunga
            ['kode' => 'BP037', 'nama' => 'Artichoke', 'jenis' => 'JP012'],
            // Buah
            // Buah Kulit Tidak Dimakan
            ['kode' => 'BP038', 'nama' => 'Semangka', 'jenis' => 'JP013'],
            ['kode' => 'BP039', 'nama' => 'Melon', 'jenis' => 'JP013'],
            ['kode' => 'BP040', 'nama' => 'Alpukat', 'jenis' => 'JP013'],
            ['kode' => 'BP041', 'nama' => 'Pepaya', 'jenis' => 'JP013'],
            ['kode' => 'BP042', 'nama' => 'Nanas', 'jenis' => 'JP013'],
            // Buah Beri dan Kecil Lainnya
            ['kode' => 'BP043', 'nama' => 'Stroberi', 'jenis' => 'JP014'],
            ['kode' => 'BP044', 'nama' => 'Cranberry', 'jenis' => 'JP014'],
            ['kode' => 'BP045', 'nama' => 'Raspberry', 'jenis' => 'JP014'],
            ['kode' => 'BP046', 'nama' => 'Blackberry', 'jenis' => 'JP014'],
            ['kode' => 'BP047', 'nama' => 'Anggur', 'jenis' => 'JP014'],
            ['kode' => 'BP048', 'nama' => 'Kismis', 'jenis' => 'JP014'],
            // 04 Jeruk (Citrus) tidak ada bahan spesifik
            ['kode' => 'BP055', 'nama' => 'Apel', 'jenis' => 'JP016'],
            ['kode' => 'BP056', 'nama' => 'Pir', 'jenis' => 'JP016'],
            ['kode' => 'BP057', 'nama' => 'Persik/Peach, termasuk Nectarine', 'jenis' => 'JP017'],
            ['kode' => 'BP058', 'nama' => 'Aprikot', 'jenis' => 'JP017'],
            ['kode' => 'BP059', 'nama' => 'Ceri', 'jenis' => 'JP017'],
            ['kode' => 'BP060', 'nama' => 'Plum', 'jenis' => 'JP017'],
            // Rempah
            ['kode' => 'BP061', 'nama' => 'Cabai Kering', 'jenis' => 'JP018'],
            // Bahan Penyegar dan Pemanis
            ['kode' => 'BP062', 'nama' => 'Biji Kopi', 'jenis' => 'JP019'],
            ['kode' => 'BP063', 'nama' => 'Biji Cokelat', 'jenis' => 'JP019'],
        ];

        foreach ($bahanList as $bahan) {
            if (!isset($jenisMap[$bahan['jenis']])) {
                continue; // skip jika jenis tidak ditemukan
            }
            MasterBahanPanganSegar::create([
                'id' => Str::uuid(),
                'jenis_id' => $jenisMap[$bahan['jenis']],
                'kode_bahan_pangan_segar' => $bahan['kode'],
                'nama_bahan_pangan_segar' => $bahan['nama'],
                'is_active' => true,
                'created_by' => 'seeder',
            ]);
        }
    }
}
