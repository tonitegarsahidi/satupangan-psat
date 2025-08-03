<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\RegisterIzinrumahPengemasan;
use App\Models\Business;
use App\Models\User;
use App\Models\MasterProvinsi;
use App\Models\MasterKota;
use App\Models\MasterJenisPanganSegar;

class RegisterIzinrumahPengemasanSeeder extends Seeder
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
                'nomor_sppb' => 'SPPB/101/2023',
                'nomor_izinrumah_pl' => 'IRP/101/2023',
                'is_unitusaha' => true,
                'nama_unitusaha' => 'PT Kemasan Indonesia',
                'alamat_unitusaha' => 'Jl. Kemasan No. 1',
                'alamat_unitpenanganan' => 'Jl. Penanganan No. 2',
                'nib_unitusaha' => 'NIB101',
                'nama_komoditas' => 'Minyak Goreng',
                'nama_latin' => 'Elaeis guineensis',
                'negara_asal' => 'Indonesia',
                'merk_dagang' => 'Minyak Sehat',
                'jenis_kemasan' => 'Botol Plastik',
                'ukuran_berat' => '2 L',
                'klaim' => 'Minyak goreng sehat',
                'foto_1' => 'minyak1.jpg',
                'foto_2' => 'minyak2.jpg',
                'foto_3' => 'minyak3.jpg',
                'file_nib' => 'nib_minyak.pdf',
                'file_sppb' => 'sppb_minyak.pdf',
                'file_izinrumah_pengemasan' => 'izin_minyak.pdf',
                'tanggal_terbit' => '2023-04-01',
                'tanggal_terakhir' => '2024-03-31',
            ],
            [
                'status' => 'approved',
                'is_enabled' => true,
                'nomor_sppb' => 'SPPB/102/2023',
                'nomor_izinrumah_pl' => 'IRP/102/2023',
                'is_unitusaha' => false,
                'nama_komoditas' => 'Saus Tomat',
                'nama_latin' => 'Solanum lycopersicum',
                'negara_asal' => 'Indonesia',
                'merk_dagang' => 'Saus Lezat',
                'jenis_kemasan' => 'Botol Kaca',
                'ukuran_berat' => '500 ml',
                'klaim' => 'Saus tomat alami',
                'foto_1' => 'saus1.jpg',
                'foto_2' => 'saus2.jpg',
                'file_nib' => 'nib_saus.pdf',
                'file_sppb' => 'sppb_saus.pdf',
                'file_izinrumah_pengemasan' => 'izin_saus.pdf',
                'tanggal_terbit' => '2023-05-01',
                'tanggal_terakhir' => '2024-04-30',
            ],
            [
                'status' => 'rejected',
                'is_enabled' => false,
                'nomor_sppb' => 'SPPB/103/2023',
                'nomor_izinrumah_pl' => 'IRP/103/2023',
                'is_unitusaha' => true,
                'nama_unitusaha' => 'CV Makanan Kemas',
                'alamat_unitusaha' => 'Jl. Makanan No. 5',
                'alamat_unitpenanganan' => 'Jl. Penanganan No. 6',
                'nib_unitusaha' => 'NIB103',
                'nama_komoditas' => 'Kerupuk',
                'nama_latin' => 'Crackers',
                'negara_asal' => 'Indonesia',
                'merk_dagang' => 'Kerupuk Renyah',
                'jenis_kemasan' => 'Plastik',
                'ukuran_berat' => '250 g',
                'klaim' => 'Kerupuk tanpa pengawet',
                'foto_1' => 'kerupuk1.jpg',
                'foto_2' => 'kerupuk2.jpg',
                'foto_3' => 'kerupuk3.jpg',
                'foto_4' => 'kerupuk4.jpg',
                'file_nib' => 'nib_kerupuk.pdf',
                'file_sppb' => 'sppb_kerupuk.pdf',
                'file_izinrumah_pengemasan' => 'izin_kerupuk.pdf',
                'tanggal_terbit' => '2023-06-01',
                'tanggal_terakhir' => '2024-05-31',
            ],
        ];

        // Create records
        foreach ($sampleData as $data) {
            $business = $businesses->random();
            $user = $users->random();
            $provinsi = $provinsis->random();
            $kota = $kotas->random();
            $jenisPsat = $jenisPsats->random();

            RegisterIzinrumahPengemasan::create([
                'id' => (string) Str::uuid(),
                'business_id' => $business->id,
                'status' => $data['status'],
                'is_enabled' => $data['is_enabled'],
                'nomor_sppb' => $data['nomor_sppb'],
                'nomor_izinrumah_pl' => $data['nomor_izinrumah_pl'],
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
                'file_izinrumah_pengemasan' => $data['file_izinrumah_pengemasan'] ?? null,
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
