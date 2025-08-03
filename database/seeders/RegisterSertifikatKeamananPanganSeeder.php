<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\RegisterSertifikatKeamananPangan;
use App\Models\Business;
use App\Models\User;
use App\Models\MasterProvinsi;
use App\Models\MasterKota;
use App\Models\MasterJenisPanganSegar;

class RegisterSertifikatKeamananPanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing data for relationships
        $businesses = Business::all();
        $users = User::all();
        $provinsis = MasterProvinsi::all();
        $kotas = MasterKota::all();
        $jenisPsats = MasterJenisPanganSegar::all();

        // Sample data
        $sampleData = [
            [
                'status' => 'pending',
                'is_enabled' => true,
                'nomor_sppb' => 'SPPB/001/2023',
                'nomor_sertifikat_keamanan_pangan' => 'SKP/001/2023',
                'is_unitusaha' => true,
                'nama_unitusaha' => 'PT Pangan Sehat Indonesia',
                'alamat_unitusaha' => 'Jl. Pangan Sehat No. 1',
                'alamat_unitpenanganan' => 'Jl. Penanganan No. 2',
                'nib_unitusaha' => 'NIB001',
                'nama_komoditas' => 'Beras',
                'nama_latin' => 'Oryza sativa',
                'negara_asal' => 'Indonesia',
                'merk_dagang' => 'Beras Sehat',
                'jenis_kemasan' => 'Kemasan Plastik',
                'ukuran_berat' => '5 kg',
                'klaim' => 'Beras organik',
                'foto_1' => 'foto1.jpg',
                'foto_2' => 'foto2.jpg',
                'foto_3' => 'foto3.jpg',
                'file_nib' => 'nib.pdf',
                'file_sppb' => 'sppb.pdf',
                'file_sertifikat_keamanan_pangan' => 'sertifikat.pdf',
                'tanggal_terbit' => '2023-01-01',
                'tanggal_terakhir' => '2023-12-31',
            ],
            [
                'status' => 'approved',
                'is_enabled' => true,
                'nomor_sppb' => 'SPPB/002/2023',
                'nomor_sertifikat_keamanan_pangan' => 'SKP/002/2023',
                'is_unitusaha' => false,
                'nama_komoditas' => 'Gula',
                'nama_latin' => 'Saccharum officinarum',
                'negara_asal' => 'Indonesia',
                'merk_dagang' => 'Gula Manis',
                'jenis_kemasan' => 'Kemasan Kertas',
                'ukuran_berat' => '1 kg',
                'klaim' => 'Gula tebu asli',
                'foto_1' => 'gula1.jpg',
                'foto_2' => 'gula2.jpg',
                'file_nib' => 'nib_gula.pdf',
                'file_sppb' => 'sppb_gula.pdf',
                'file_sertifikat_keamanan_pangan' => 'sertifikat_gula.pdf',
                'tanggal_terbit' => '2023-02-01',
                'tanggal_terakhir' => '2024-01-31',
            ],
            [
                'status' => 'rejected',
                'is_enabled' => false,
                'nomor_sppb' => 'SPPB/003/2023',
                'nomor_sertifikat_keamanan_pangan' => 'SKP/003/2023',
                'is_unitusaha' => true,
                'nama_unitusaha' => 'CV Makanan Sehat',
                'alamat_unitusaha' => 'Jl. Makanan No. 3',
                'alamat_unitpenanganan' => 'Jl. Penanganan No. 4',
                'nib_unitusaha' => 'NIB003',
                'nama_komoditas' => 'Tepung Terigu',
                'nama_latin' => 'Triticum aestivum',
                'negara_asal' => 'Indonesia',
                'merk_dagang' => 'Tepung Berkualitas',
                'jenis_kemasan' => 'Kemasan Kertas',
                'ukuran_berat' => '2 kg',
                'klaim' => 'Tepung protein tinggi',
                'foto_1' => 'tepung1.jpg',
                'foto_2' => 'tepung2.jpg',
                'foto_3' => 'tepung3.jpg',
                'foto_4' => 'tepung4.jpg',
                'file_nib' => 'nib_tepung.pdf',
                'file_sppb' => 'sppb_tepung.pdf',
                'file_sertifikat_keamanan_pangan' => 'sertifikat_tepung.pdf',
                'tanggal_terbit' => '2023-03-01',
                'tanggal_terakhir' => '2024-02-29',
            ],
        ];

        // Create records
        foreach ($sampleData as $data) {
            $business = $businesses->random();
            $user = $users->random();
            $provinsi = $provinsis->random();
            $kota = $kotas->random();
            $jenisPsat = $jenisPsats->random();

            RegisterSertifikatKeamananPangan::create([
                'id' => (string) Str::uuid(),
                'business_id' => $business->id,
                'status' => $data['status'],
                'is_enabled' => $data['is_enabled'],
                'nomor_sppb' => $data['nomor_sppb'],
                'nomor_sertifikat_keamanan_pangan' => $data['nomor_sertifikat_keamanan_pangan'],
                'is_unitusaha' => $data['is_unitusaha'],
                'nama_unitusaha' => $data['nama_unitusaha'] ?? null,
                'alamat_unitusaha' => $data['alamat_unitusaha'] ?? null,
                'alamat_unitpenanganan' => $data['alamat_unitpenanganan'] ?? null,
                'provinsi_unitusaha' => $data['is_unitusaha'] ? $provinsi->id : null,
                'kota_unitusaha' => $data['is_unitusaha'] ? $kota->id : null,
                'nib_unitusaha' => $data['nib_unitusaha'] ?? null,
                'jenis_psat' => $jenisPsat->id,
                'nama_komoditas' => $data['nama_komoditas'],
                'nama_latin' => $data['nama_latin'],
                'negara_asal' => $data['negara_asal'],
                'merk_dagang' => $data['merk_dagang'],
                'jenis_kemasan' => $data['jenis_kemasan'],
                'ukuran_berat' => $data['ukuran_berat'],
                'klaim' => $data['klaim'],
                'foto_1' => $data['foto_1'] ?? null,
                'foto_2' => $data['foto_2'] ?? null,
                'foto_3' => $data['foto_3'] ?? null,
                'foto_4' => $data['foto_4'] ?? null,
                'foto_5' => $data['foto_5'] ?? null,
                'foto_6' => $data['foto_6'] ?? null,
                'file_nib' => $data['file_nib'] ?? null,
                'file_sppb' => $data['file_sppb'] ?? null,
                'file_sertifikat_keamanan_pangan' => $data['file_sertifikat_keamanan_pangan'] ?? null,
                'okkp_penangungjawab' => $user->id,
                'tanggal_terbit' => $data['tanggal_terbit'],
                'tanggal_terakhir' => $data['tanggal_terakhir'],
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
