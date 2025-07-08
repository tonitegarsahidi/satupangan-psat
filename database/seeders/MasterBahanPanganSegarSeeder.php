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
            ['kode' => 'BP013', 'nama' => 'Flowerhead Brassica (Brokoli, Kembang Kol)', 'jenis' => 'JP005'],
            ['kode' => 'BP014', 'nama' => 'Kulbis', 'jenis' => 'JP005'],
            ['kode' => 'BP015', 'nama' => 'Kailan, Kale, Collard Greens dan Kubis-Kubisan Daun Laimiya', 'jenis' => 'JP005'],
            ['kode' => 'BP016', 'nama' => 'Kubis', 'jenis' => 'JP005'],
            ['kode' => 'BP017', 'nama' => 'Kembang Kol', 'jenis' => 'JP005'],
            ['kode' => 'BP018', 'nama' => 'Bawang Daun', 'jenis' => 'JP006'],
            ['kode' => 'BP019', 'nama' => 'Bawang Putih', 'jenis' => 'JP006'],
            ['kode' => 'BP020', 'nama' => 'Bawang Bombay', 'jenis' => 'JP006'],
            ['kode' => 'BP021', 'nama' => 'Bawang Merah', 'jenis' => 'JP006'],
            ['kode' => 'BP022', 'nama' => 'Green Onion (Bawang Daun, Leek, Kucai/Chives)', 'jenis' => 'JP006'],
            ['kode' => 'BP023', 'nama' => 'Kucai/Chives Kering', 'jenis' => 'JP006'],
            ['kode' => 'BP024', 'nama' => 'Sayuran Buah, Kelompok Cucurbita-Melons, Pumpkins and Winter Squashes (Waluh, Squash)', 'jenis' => 'JP007'],
            ['kode' => 'BP025', 'nama' => 'Mentimun', 'jenis' => 'JP007'],
            ['kode' => 'BP026', 'nama' => 'Terung', 'jenis' => 'JP007'],
            ['kode' => 'BP027', 'nama' => 'Tomat', 'jenis' => 'JP007'],
            ['kode' => 'BP028', 'nama' => 'Tomat Kering', 'jenis' => 'JP007'],
            ['kode' => 'BP029', 'nama' => 'Pepper (termasuk Okra, Paprika, Cabai)', 'jenis' => 'JP007'],
            ['kode' => 'BP030', 'nama' => 'Sayuran Buah Kelompok Cucurbita (termasuk Courgette/Zuccini, Waluh, Squash, Labu Putih/Labu Air, Pare, Pare Belut, Labu Siam, Winter Melon, Gambas, Blustru)', 'jenis' => 'JP007'],
            ['kode' => 'BP031', 'nama' => 'Sayuran Buah, selain kelompok Cucurbita Mentimun', 'jenis' => 'JP007'],
            ['kode' => 'BP032', 'nama' => 'Tomat Asparagus', 'jenis' => 'JP007'],
            ['kode' => 'BP033', 'nama' => 'Kacang Panjang', 'jenis' => 'JP007'],
            ['kode' => 'BP034', 'nama' => 'Cabai', 'jenis' => 'JP007'],
            ['kode' => 'BP035', 'nama' => 'Leafy Greens (termasuk Selada, Endive, Bayam, Chard, Daun Kacang)', 'jenis' => 'JP008'],
            ['kode' => 'BP036', 'nama' => 'Leaves of Brassicaceae (termasuk Bayam Komatsuna, Caisim, Sawi Pahit, Sawi putih, Pak Choi, Anugula/Rocket)', 'jenis' => 'JP008'],
            ['kode' => 'BP037', 'nama' => 'Bayam Selada', 'jenis' => 'JP008'],
            ['kode' => 'BP038', 'nama' => 'Selada', 'jenis' => 'JP008'],
            ['kode' => 'BP039', 'nama' => 'Kentang', 'jenis' => 'JP009'],
            ['kode' => 'BP040', 'nama' => 'Stems and Petioles (Seledri Batang, Rhubarb)', 'jenis' => 'JP010'],
            ['kode' => 'BP041', 'nama' => 'Seledri Batang/Celery', 'jenis' => 'JP011'],
            ['kode' => 'BP042', 'nama' => 'Artichoke', 'jenis' => 'JP012'],
            // Buah
            ['kode' => 'BP043', 'nama' => 'Sayuran Buah, Kelompok Cucurbita-Melons, Pumpkins and Winter Squashes (Semangka, Cantaloupe, Melon)', 'jenis' => 'JP013'],
            ['kode' => 'BP044', 'nama' => 'Pisang Kiwi', 'jenis' => 'JP013'],
            ['kode' => 'BP045', 'nama' => 'Alpukat', 'jenis' => 'JP013'],
            ['kode' => 'BP046', 'nama' => 'Pepaya', 'jenis' => 'JP013'],
            ['kode' => 'BP047', 'nama' => 'Nenas', 'jenis' => 'JP013'],
            ['kode' => 'BP048', 'nama' => 'Melon', 'jenis' => 'JP013'],
            ['kode' => 'BP049', 'nama' => 'Lou Grouting Berries (Cranberry, Stroberi)', 'jenis' => 'JP014'],
            ['kode' => 'BP050', 'nama' => 'Cranberry', 'jenis' => 'JP014'],
            ['kode' => 'BP051', 'nama' => 'Stroberi', 'jenis' => 'JP014'],
            ['kode' => 'BP052', 'nama' => 'Cane Berites(Raspberries, Blackberry, Deubernies, Boysenberry, Loganberry)', 'jenis' => 'JP014'],
            ['kode' => 'BP053', 'nama' => 'Anggur', 'jenis' => 'JP014'],
            ['kode' => 'BP054', 'nama' => 'Kering/Raisin/Kismis', 'jenis' => 'JP014'],
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
