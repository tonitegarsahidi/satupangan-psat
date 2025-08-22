<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\MasterBahanPanganSegar;
use App\Models\MasterCemaranLogamBerat;
use App\Models\MasterCemaranMikroba;
use App\Models\MasterCemaranMikrotoksin;
use App\Models\MasterCemaranPestisida;
use Illuminate\Support\Str;

class EarlyWarningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a user for creator_id (assuming there's at least one user)
        $user = User::where('email', 'kantorpusat@panganaman.my.id')->first();
        if (!$user) {
            // If no user exists, create one
            $user = User::create([
                'id' => Str::uuid(),
                'name' => 'System Administrator',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'is_active' => true,
            ]);
        }

        // Get some sample fresh food materials
        $beras = MasterBahanPanganSegar::where('nama_bahan_pangan_segar', 'Beras')->first();
        $tomat = MasterBahanPanganSegar::where('nama_bahan_pangan_segar', 'Tomat')->first();
        $kacangTanah = MasterBahanPanganSegar::where('nama_bahan_pangan_segar', 'Kacang Tanah')->first();

        // Get some contaminants
        $timbal = MasterCemaranLogamBerat::where('nama_cemaran_logam_berat', 'Timbal (Pb)')->first();
        $aflatoksin = MasterCemaranMikrotoksin::where('nama_cemaran_mikrotoksin', 'Aflatoksin')->first();
        $karbofuran = MasterCemaranPestisida::where('nama_cemaran_pestisida', 'Karbofuran')->first();
        $eColi = MasterCemaranMikroba::where('nama_cemaran_mikroba', 'Escherichia coli')->first();

        // Early warning data about contaminants in fresh food materials
        $earlyWarnings = [
            [
                'creator_id' => $user->id,
                'status' => 'Published',
                'title' => 'Tingkat Timbal (Pb) Melebihi Batas Aman pada Beras Impor',
                'content' => 'Berdasarkan hasil pengawasan laboratorium, ditemukan tingkat timbal (Pb) pada beberapa sampel beras impor yang melebihi batas maksimum yang diizinkan. Timbal dapat menyebabkan gangguan sistem saraf dan perkembangan anak jika dikonsumsi dalam jangka panjang.',
                'related_product' => $beras ? $beras->nama_bahan_pangan_segar : 'Beras',
                'preventive_steps' => '1. Hindari mengonsumsi beras impor dari sumber yang tidak terjamin kualitasnya\n2. Lakukan pengujian laboratorium sebelum mengonsumsi beras impor\n3. Pilih beras lokal dengan sertifikasi keamanan pangan\n4. Simpan beras dalam wadah yang tertutup rapat untuk mencegah kontaminasi',
                'urgency_level' => 'Danger',
                'url' => 'https://www.badanpangan.go.id/berita/detail/peringatan-dini-tingkat-timbal-pada-beras-impor'
            ],
            [
                'creator_id' => $user->id,
                'status' => 'Published',
                'title' => 'Ditemukan Residu Pestisida Karbofuran pada Tomat',
                'content' => 'Beberapa sampel tomat yang diuji di laboratorium ditemukan mengandung residu pestisida karbofuran yang melebihi batas maksimum. Karbofuran termasuk pestisida golongan karbamat yang berbahaya bagi kesehatan jika terpapar dalam jumlah banyak.',
                'related_product' => $tomat ? $tomat->nama_bahan_pangan_segar : 'Tomat',
                'preventive_steps' => '1. Cuci tomat dengan air mengalir dan sedikit deterjen makanan\n2. Bilas dengan air bersih hingga bersih\n3. Kupas kulit tomat sebelum dikonsumsi\n4. Hindari mengonsumsi tomat yang masih berbau pestisida',
                'urgency_level' => 'Warning',
                'url' => 'https://www.badanpangan.go.id/berita/detail/residu-pestisida-pada-tomat'
            ],
            [
                'creator_id' => $user->id,
                'status' => 'Published',
                'title' => 'Kontaminasi Aflatoksin pada Kacang Tanah',
                'content' => 'Hasil pengawasan menunjukkan adanya kontaminasi aflatoksin pada beberapa produk kacang tanah. Aflatoksin adalah mikrotoksin yang dihasilkan oleh jamur dan dapat menyebabkan kanker hati jika dikonsumsi dalam jangka panjang.',
                'related_product' => $kacangTanah ? $kacangTanah->nama_bahan_pangan_segar : 'Kacang Tanah',
                'preventive_steps' => '1. Periksa kacang tanah sebelum membeli - hindari yang berjamur atau berbau tidak sedap\n2. Simpan kacang tanah di tempat kering dan sejuk\n3. Hindari menyimpan kacang tanah terlalu lama\n4. Gunakan kacang tanah dari sumber terpercaya',
                'urgency_level' => 'Danger',
                'url' => 'https://www.badanpangan.go.id/berita/detail/kontaminasi-aflatoksin-pada-kacang-tanah'
            ],
            [
                'creator_id' => $user->id,
                'status' => 'Draft',
                'title' => 'Potensi Kontaminasi E. coli pada Sayuran Segar',
                'content' => 'Beberapa laporan menunjukkan adanya potensi kontaminasi Escherichia coli pada sayuran segar yang tidak dicuci dengan benar. E. coli dapat menyebabkan gangguan pencernaan yang serius.',
                'related_product' => 'Sayuran Segar',
                'preventive_steps' => '1. Cuci semua sayuran dengan air mengalir sebelum dikonsumsi\n2. Gunakan air bersih untuk mencuci sayuran\n3. Hindari menyantap sayuran mentah jika tidak yakin kebersihannya\n4. Simpan sayuran dalam suhu yang tepat',
                'urgency_level' => 'Info',
                'url' => null
            ],
            [
                'creator_id' => $user->id,
                'status' => 'Approved',
                'title' => 'Pembaruan Standar Keamanan Pangan untuk Produk Olahan',
                'content' => 'Badan Pengawas Pangan dan Obat-obatan telah mengumumkan pembaruan standar keamanan pangan untuk produk olahan. Standar baru ini akan berlaku mulai 1 Januari 2025.',
                'related_product' => 'Produk Olahan',
                'preventive_steps' => '1. Pelajari standar keamanan pangan yang baru\n2. Sesuaikan proses produksi dengan standar yang telah diperbarui\n3. Lakukan pelatihan kepada karyawan tentang standar baru\n4. Dokumentasikan semua langkah keamanan pangan yang dilakukan',
                'urgency_level' => 'Info',
                'url' => 'https://www.badanpangan.go.id/berita/detail/pembaruan-standar-keamanan-pangan'
            ]
        ];

        foreach ($earlyWarnings as $warning) {
            \App\Models\EarlyWarning::create($warning);
        }
    }
}
