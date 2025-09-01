<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RegisterIzinedarPsatpd;
use App\Models\Business;
use App\Models\User;
use App\Models\MasterProvinsi;
use App\Models\MasterKota;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterKelompokPangan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RegisterIzinedarPsatpdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the user with email pengusaha@panganaman.my.id
        $user = User::where('email', 'pengusaha@panganaman.my.id')->first();
        if (!$user) {
            $this->command->error('User with email pengusaha@panganaman.my.id not found. Please ensure the user exists before running this seeder.');
            return;
        }

        $userpetugas = User::where('email', 'kantorjatim@panganaman.my.id')->first();
        if (!$userpetugas) {
            $this->command->error('User with email kantorjatim@panganaman.my.id not found. Please ensure the user exists before running this seeder.');
            return;
        }

        // Get the business associated with this user
        $business = Business::where('user_id', $user->id)->first();
        if (!$business) {
            $this->command->error('No business found for user pengusaha@panganaman.my.id. Please ensure the business exists before running this seeder.');
            return;
        }

        // Get sample provinsi and kota (using Jawa Timur and Kota Malang as examples)
        $provinsi = MasterProvinsi::where('nama_provinsi', 'Jawa Timur')->first();
        $kota = MasterKota::where('nama_kota', 'Kota Malang')->first();

        // Get a sample jenis_psat
        $jenispsat1 = MasterJenisPanganSegar::where('nama_jenis_pangan_segar', 'Buah Kulit Tidak Dimakan')->first();
        if (!$jenispsat1) {
            $kelompok1 = MasterKelompokPangan::where('nama_kelompok_pangan', 'Buah')->first();
            if (!$kelompok1) {
                $kelompok1 = MasterKelompokPangan::create([
                    'id' => Str::uuid(),
                    'kode_kelompok_pangan' => 'KB001',
                    'nama_kelompok_pangan' => 'Buah',
                    'is_active' => true,
                ]);
            }
            $jenispsat1 = MasterJenisPanganSegar::create([
                'id' => Str::uuid(),
                'kelompok_id' => $kelompok1->id,
                'kode_jenis_pangan_segar' => 'JP013',
                'nama_jenis_pangan_segar' => 'Buah Kulit Tidak Dimakan',
                'is_active' => true,
            ]);
        }

        $jenispsat2 = MasterJenisPanganSegar::where('nama_jenis_pangan_segar', 'Sayuran Umbi dan Akar')->first();
        if (!$jenispsat2) {
            $kelompok2 = MasterKelompokPangan::where('nama_kelompok_pangan', 'Sayur, termasuk Jamur')->first();
            if (!$kelompok2) {
                $kelompok2 = MasterKelompokPangan::create([
                    'id' => Str::uuid(),
                    'kode_kelompok_pangan' => 'KS001',
                    'nama_kelompok_pangan' => 'Sayur, termasuk Jamur',
                    'is_active' => true,
                ]);
            }
            $jenispsat2 = MasterJenisPanganSegar::create([
                'id' => Str::uuid(),
                'kelompok_id' => $kelompok2->id,
                'kode_jenis_pangan_segar' => 'JP009',
                'nama_jenis_pangan_segar' => 'Sayuran Umbi dan Akar',
                'is_active' => true,
            ]);
        }

        // Create sample data for register_izinedar_Psatpd
        RegisterIzinedarPsatpd::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DIAJUKAN',
            'is_enabled' => true,
            'nomor_sppb' => 'REG-SPPB-KMSN-002',
            'nomor_izinedar_pd' => 'REG-IZINPD-KNTNG-001',

            // Unit usaha data
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha Kentang',
            'alamat_unitusaha' => 'Jl. Kentang Manis No. 1',
            'alamat_unitpenanganan' => 'Jl. Kentang Manis No. 1',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => 'NIB-MELON-001',

            'jenis_psat' => $jenispsat2?->id,

            'nama_komoditas' => 'Kentang',
            'nama_latin' => 'Solanum tuberosum',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Kentang Garut',
            'jenis_kemasan' => 'Sakel',
            'ukuran_berat' => '20 kg per sakel',
            'klaim' => 'Pangan Lokal, Berkualitas Export',
            'foto_1' => 'images/upload/register/kentang1.jpg',
            'foto_2' => 'images/upload/register/kentang2.jpg',
            'foto_3' => 'images/upload/register/kentang3.jpg',
            'foto_4' => 'images/upload/register/kentang4.jpg',
            'foto_5' => 'images/upload/register/kentang5.jpg',
            'foto_6' => null,
            'file_nib' => 'files/upload/register/contohdokumen.pdf',
            'file_sppb' => 'files/upload/register/contohdokumen.pdf',
            'file_izinedar_Psatpd' => 'files/upload/register/contohdokumen.pdf',

            'okkp_penangungjawab' => $user->id,

            'tanggal_terbit' => '2025-01-01',
            'tanggal_terakhir' => '2026-01-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create a second sample entry
        RegisterIzinedarPsatpd::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DISETUJUI',
            'is_enabled' => true,
            'nomor_sppb' => 'SPPB-IZIN-002',
            'nomor_izinedar_pd' => 'REG-IZINPDUK-002',

            // Unit usaha data
            'is_unitusaha' => false,
            'nama_unitusaha' => null,
            'alamat_unitusaha' => null,
            'alamat_unitpenanganan' => 'Jl. Pengolahan Kentang No. 5',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => null,

            'jenis_psat' => $jenispsat2?->id,

            'nama_komoditas' => 'Kentang',
            'nama_latin' => 'Solanum tuberosum',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Kentang Kita',
            'jenis_kemasan' => 'Karung',
            'ukuran_berat' => '20 kg per karung',
            'klaim' => 'Pangan Lokal, Berkualitas Export',
            'foto_1' => env('APP_URL').'/'.'images/upload/register/kentang_7.jpg',
            'foto_2' => env('APP_URL').'/'.'images/upload/register/kentang_8.jpg',
            'foto_3' => env('APP_URL').'/'.'images/upload/register/kentang_9.jpg',
            'foto_4' => env('APP_URL').'/'.'images/upload/register/kentang_10.jpg',
            'foto_5' => env('APP_URL').'/'.'images/upload/register/kentang_11.jpg',
            'foto_6' => env('APP_URL').'/'.'images/upload/register/kentang_12.jpg',
            'file_nib' => env('APP_URL').'/'.'files/upload/register/NIB-KENTANG-002.pdf',
            'file_sppb' => env('APP_URL').'/'.'files/upload/register/SPPB-KENTANG-002.pdf',
            'file_izinedar_Psatpd' =>  env('APP_URL').'/'.'files/upload/register/IZIN-KENTANG-002.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-02-01',
            'tanggal_terakhir' => '2026-02-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create third sample entry for Pisang
        RegisterIzinedarPsatpd::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DIAJUKAN',
            'is_enabled' => true,
            'nomor_sppb' => 'REG-SPPB-KMSN-002',
            'nomor_izinedar_pd' => 'REG-IZINPD-KNTNG-003',

            // Unit usaha data
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha Pisang',
            'alamat_unitusaha' => 'Jl. Pisang Manis No. 2',
            'alamat_unitpenanganan' => 'Jl. Pisang Manis No. 2',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => 'NIB-PI-001',

            'jenis_psat' => $jenispsat1?->id,

            'nama_komoditas' => 'Kentang',
            'nama_latin' => 'Solanum tuberosum',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Kentang Garut',
            'jenis_kemasan' => 'Kardus',
            'ukuran_berat' => '15 kg per kardus',
            'klaim' => 'Pangan Lokal, Berkualitas Export',
            'foto_1' => 'images/upload/register/pisang1.jpg',
            'foto_2' => 'images/upload/register/pisang2.jpg',
            'foto_3' => 'images/upload/register/pisang3.jpg',
            'foto_4' => 'images/upload/register/pisang4.jpg',
            'foto_5' => 'images/upload/register/pisang5.jpg',
            'foto_6' => null,
            'file_nib' => 'files/upload/register/contohdokumen.pdf',
            'file_sppb' => 'files/upload/register/contohdokumen.pdf',
            'file_izinedar_Psatpd' => 'files/upload/register/contohdokumen.pdf',

            'okkp_penangungjawab' => $user->id,

            'tanggal_terbit' => '2025-03-01',
            'tanggal_terakhir' => '2026-03-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create fourth sample entry for Semangka
        RegisterIzinedarPsatpd::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DISETUJUI',
            'is_enabled' => true,
            'nomor_sppb' => 'REG-SPPB-KMSN-004',
            'nomor_izinedar_pd' => 'REG-IZINPDUK-004',

            // Unit usaha data
            'is_unitusaha' => false,
            'nama_unitusaha' => null,
            'alamat_unitusaha' => null,
            'alamat_unitpenanganan' => 'Jl. Pengolahan Semangka No. 6',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => null,

            'jenis_psat' => $jenispsat1?->id,

            'nama_komoditas' => 'Kentang',
            'nama_latin' => 'Solanum tuberosum',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Kentang Garut',
            'jenis_kemasan' => 'Karton',
            'ukuran_berat' => '10 kg per karton',
            'klaim' => 'Pangan Lokal, Berkualitas Export',
            'foto_1' => env('APP_URL').'/'.'images/upload/register/semangka_7.jpg',
            'foto_2' => env('APP_URL').'/'.'images/upload/register/semangka_8.jpg',
            'foto_3' => env('APP_URL').'/'.'images/upload/register/semangka_9.jpg',
            'foto_4' => env('APP_URL').'/'.'images/upload/register/semangka_10.jpg',
            'foto_5' => env('APP_URL').'/'.'images/upload/register/semangka_11.jpg',
            'foto_6' => env('APP_URL').'/'.'images/upload/register/semangka_12.jpg',
            'file_nib' => env('APP_URL').'/'.'files/upload/register/NIB-SEMANGKA-004.pdf',
            'file_sppb' => env('APP_URL').'/'.'files/upload/register/SPPB-SEMANGKA-004.pdf',
            'file_izinedar_Psatpd' =>  env('APP_URL').'/'.'files/upload/register/IZIN-SEMANGKA-004.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-04-01',
            'tanggal_terakhir' => '2026-04-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create fifth sample entry for Alpukat
        RegisterIzinedarPsatpd::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DIAJUKAN',
            'is_enabled' => true,
            'nomor_sppb' => 'REG-SPPB-KMSN-006',
            'nomor_izinedar_pd' => 'REG-IZINPD-KNTNG-005',

            // Unit usaha data
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha Alpukat',
            'alamat_unitusaha' => 'Jl. Alpukat Hijau No. 3',
            'alamat_unitpenanganan' => 'Jl. Alpukat Hijau No. 3',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => 'NIB-AL-002',

            'jenis_psat' => $jenispsat1?->id,

            'nama_komoditas' => 'Kentang',
            'nama_latin' => 'Solanum tuberosum',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Kentang Garut',
            'jenis_kemasan' => 'Sakel',
            'ukuran_berat' => '5 kg per sakel',
            'klaim' => 'Pangan Lokal, Berkualitas Export',
            'foto_1' => 'images/upload/register/alpukat1.jpg',
            'foto_2' => 'images/upload/register/alpukat2.jpg',
            'foto_3' => 'images/upload/register/alpukat3.jpg',
            'foto_4' => 'images/upload/register/alpukat4.jpg',
            'foto_5' => 'images/upload/register/alpukat5.jpg',
            'foto_6' => null,
            'file_nib' => 'files/upload/register/contohdokumen.pdf',
            'file_sppb' => 'files/upload/register/contohdokumen.pdf',
            'file_izinedar_Psatpd' => 'files/upload/register/contohdokumen.pdf',

            'okkp_penangungjawab' => $user->id,

            'tanggal_terbit' => '2025-05-01',
            'tanggal_terakhir' => '2026-05-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create sixth sample entry for Tomat
        RegisterIzinedarPsatpd::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DISETUJUI',
            'is_enabled' => true,
            'nomor_sppb' => 'REG-SPPB-KMSN-008',
            'nomor_izinedar_pd' => 'REG-IZINPDUK-006',

            // Unit usaha data
            'is_unitusaha' => false,
            'nama_unitusaha' => null,
            'alamat_unitusaha' => null,
            'alamat_unitpenanganan' => 'Jl. Pengolahan Tomat No. 7',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => null,

            'jenis_psat' => $jenispsat2?->id,

            'nama_komoditas' => 'Kentang',
            'nama_latin' => 'Solanum tuberosum',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Kentang Garut',
            'jenis_kemasan' => 'Pet',
            'ukuran_berat' => '1 kg per pet',
            'klaim' => 'Pangan Lokal, Berkualitas Export',
            'foto_1' => env('APP_URL').'/'.'images/upload/register/tomat_7.jpg',
            'foto_2' => env('APP_URL').'/'.'images/upload/register/tomat_8.jpg',
            'foto_3' => env('APP_URL').'/'.'images/upload/register/tomat_9.jpg',
            'foto_4' => env('APP_URL').'/'.'images/upload/register/tomat_10.jpg',
            'foto_5' => env('APP_URL').'/'.'images/upload/register/tomat_11.jpg',
            'foto_6' => env('APP_URL').'/'.'images/upload/register/tomat_12.jpg',
            'file_nib' => env('APP_URL').'/'.'files/upload/register/NIB-TOMAT-006.pdf',
            'file_sppb' => env('APP_URL').'/'.'files/upload/register/SPPB-TOMAT-006.pdf',
            'file_izinedar_Psatpd' =>  env('APP_URL').'/'.'files/upload/register/IZIN-TOMAT-006.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-06-01',
            'tanggal_terakhir' => '2026-06-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create seventh sample entry for Mangga
        RegisterIzinedarPsatpd::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DIAJUKAN',
            'is_enabled' => true,
            'nomor_sppb' => 'REG-SPPB-KMSN-010',
            'nomor_izinedar_pd' => 'REG-IZINPD-KNTNG-007',

            // Unit usaha data
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha Mangga',
            'alamat_unitusaha' => 'Jl. Mangga Manis No. 4',
            'alamat_unitpenanganan' => 'Jl. Mangga Manis No. 4',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => 'NIB-MG-003',

            'jenis_psat' => $jenispsat1?->id,

            'nama_komoditas' => 'Kentang',
            'nama_latin' => 'Solanum tuberosum',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Kentang Garut',
            'jenis_kemasan' => 'Kardus',
            'ukuran_berat' => '8 kg per kardus',
            'klaim' => 'Pangan Lokal, Berkualitas Export',
            'foto_1' => 'images/upload/register/mangga1.jpg',
            'foto_2' => 'images/upload/register/mangga2.jpg',
            'foto_3' => 'images/upload/register/mangga3.jpg',
            'foto_4' => 'images/upload/register/mangga4.jpg',
            'foto_5' => 'images/upload/register/mangga5.jpg',
            'foto_6' => null,
            'file_nib' => 'files/upload/register/contohdokumen.pdf',
            'file_sppb' => 'files/upload/register/contohdokumen.pdf',
            'file_izinedar_Psatpd' => 'files/upload/register/contohdokumen.pdf',

            'okkp_penangungjawab' => $user->id,

            'tanggal_terbit' => '2025-07-01',
            'tanggal_terakhir' => '2026-07-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create eighth sample entry for Kubis
        RegisterIzinedarPsatpd::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DISETUJUI',
            'is_enabled' => true,
            'nomor_sppb' => 'REG-SPPB-KMSN-012',
            'nomor_izinedar_pd' => 'REG-IZINPDUK-008',

            // Unit usaha data
            'is_unitusaha' => false,
            'nama_unitusaha' => null,
            'alamat_unitusaha' => null,
            'alamat_unitpenanganan' => 'Jl. Pengolahan Kubis No. 8',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => null,

            'jenis_psat' => $jenispsat2?->id,

            'nama_komoditas' => 'Kentang',
            'nama_latin' => 'Solanum tuberosum',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Kentang Garut',
            'jenis_kemasan' => 'Kardus',
            'ukuran_berat' => '12 kg per kardus',
            'klaim' => 'Pangan Lokal, Berkualitas Export',
            'foto_1' => env('APP_URL').'/'.'images/upload/register/kubis_7.jpg',
            'foto_2' => env('APP_URL').'/'.'images/upload/register/kubis_8.jpg',
            'foto_3' => env('APP_URL').'/'.'images/upload/register/kubis_9.jpg',
            'foto_4' => env('APP_URL').'/'.'images/upload/register/kubis_10.jpg',
            'foto_5' => env('APP_URL').'/'.'images/upload/register/kubis_11.jpg',
            'foto_6' => env('APP_URL').'/'.'images/upload/register/kubis_12.jpg',
            'file_nib' => env('APP_URL').'/'.'files/upload/register/NIB-KUBIS-008.pdf',
            'file_sppb' => env('APP_URL').'/'.'files/upload/register/SPPB-KUBIS-008.pdf',
            'file_izinedar_Psatpd' =>  env('APP_URL').'/'.'files/upload/register/IZIN-KUBIS-008.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-08-01',
            'tanggal_terakhir' => '2026-08-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create ninth sample entry for Jeruk
        RegisterIzinedarPsatpd::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DIAJUKAN',
            'is_enabled' => true,
            'nomor_sppb' => 'REG-SPPB-KMSN-002',
            'nomor_izinedar_pd' => 'REG-IZINPD-KNTNG-009',

            // Unit usaha data
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha Jeruk',
            'alamat_unitusaha' => 'Jl. Jeruk Bali No. 5',
            'alamat_unitpenanganan' => 'Jl. Jeruk Bali No. 5',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => 'NIB-JR-004',

            'jenis_psat' => $jenispsat1?->id,

            'nama_komoditas' => 'Kentang',
            'nama_latin' => 'Solanum tuberosum',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Kentang Garut',
            'jenis_kemasan' => 'Karton',
            'ukuran_berat' => '20 kg per karton',
            'klaim' => 'Pangan Lokal, Berkualitas Export',
            'foto_1' => 'images/upload/register/jeruk1.jpg',
            'foto_2' => 'images/upload/register/jeruk2.jpg',
            'foto_3' => 'images/upload/register/jeruk3.jpg',
            'foto_4' => 'images/upload/register/jeruk4.jpg',
            'foto_5' => 'images/upload/register/jeruk5.jpg',
            'foto_6' => null,
            'file_nib' => 'files/upload/register/contohdokumen.pdf',
            'file_sppb' => 'files/upload/register/contohdokumen.pdf',
            'file_izinedar_Psatpd' => 'files/upload/register/contohdokumen.pdf',

            'okkp_penangungjawab' => $user->id,

            'tanggal_terbit' => '2025-09-01',
            'tanggal_terakhir' => '2026-09-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create tenth sample entry for Labu
        RegisterIzinedarPsatpd::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DISETUJUI',
            'is_enabled' => true,
            'nomor_sppb' => 'SPPB-LB-010',
            'nomor_izinedar_pd' => 'REG-IZINPDUK-010',

            // Unit usaha data
            'is_unitusaha' => false,
            'nama_unitusaha' => null,
            'alamat_unitusaha' => null,
            'alamat_unitpenanganan' => 'Jl. Pengolahan Labu No. 9',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => null,

            'jenis_psat' => $jenispsat2?->id,

            'nama_komoditas' => 'Kentang',
            'nama_latin' => 'Cucurbita pepo',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Labu Siam',
            'jenis_kemasan' => 'Karung',
            'ukuran_berat' => '25 kg per karung',
            'klaim' => 'Pangan Lokal, Berkualitas Export',
            'foto_1' => env('APP_URL').'/'.'images/upload/register/labu_7.jpg',
            'foto_2' => env('APP_URL').'/'.'images/upload/register/labu_8.jpg',
            'foto_3' => env('APP_URL').'/'.'images/upload/register/labu_9.jpg',
            'foto_4' => env('APP_URL').'/'.'images/upload/register/labu_10.jpg',
            'foto_5' => env('APP_URL').'/'.'images/upload/register/labu_11.jpg',
            'foto_6' => env('APP_URL').'/'.'images/upload/register/labu_12.jpg',
            'file_nib' => env('APP_URL').'/'.'files/upload/register/NIB-LABU-010.pdf',
            'file_sppb' => env('APP_URL').'/'.'files/upload/register/SPPB-LABU-010.pdf',
            'file_izinedar_Psatpd' =>  env('APP_URL').'/'.'files/upload/register/IZIN-LABU-010.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-10-01',
            'tanggal_terakhir' => '2026-10-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create eleventh sample entry for Kacang Panjang
        RegisterIzinedarPsatpd::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DIAJUKAN',
            'is_enabled' => true,
            'nomor_sppb' => 'SPPB-KC-011',
            'nomor_izinedar_pd' => 'REG-IZINPD-KNTNG-011',

            // Unit usaha data
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha Kacang Panjang',
            'alamat_unitusaha' => 'Jl. Kacang Panjang Hijau No. 6',
            'alamat_unitpenanganan' => 'Jl. Kacang Panjang Hijau No. 6',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => 'NIB-KC-005',

            'jenis_psat' => $jenispsat2?->id,

            'nama_komoditas' => 'Kentang',
            'nama_latin' => 'Vigna unguiculata',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Kacang Panjang Hijau',
            'jenis_kemasan' => 'Pet',
            'ukuran_berat' => '500 gr per pet',
            'klaim' => 'Pangan Lokal, Berkualitas Export',
            'foto_1' => 'images/upload/register/kacang1.jpg',
            'foto_2' => 'images/upload/register/kacang2.jpg',
            'foto_3' => 'images/upload/register/kacang3.jpg',
            'foto_4' => 'images/upload/register/kacang4.jpg',
            'foto_5' => 'images/upload/register/kacang5.jpg',
            'foto_6' => null,
            'file_nib' => 'files/upload/register/contohdokumen.pdf',
            'file_sppb' => 'files/upload/register/contohdokumen.pdf',
            'file_izinedar_Psatpd' => 'files/upload/register/contohdokumen.pdf',

            'okkp_penangungjawab' => $user->id,

            'tanggal_terbit' => '2025-11-01',
            'tanggal_terakhir' => '2026-11-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create twelfth sample entry for Bawang Merah
        RegisterIzinedarPsatpd::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DISETUJUI',
            'is_enabled' => true,
            'nomor_sppb' => 'SPPB-BW-012',
            'nomor_izinedar_pd' => 'REG-IZINPDUK-012',

            // Unit usaha data
            'is_unitusaha' => false,
            'nama_unitusaha' => null,
            'alamat_unitusaha' => null,
            'alamat_unitpenanganan' => 'Jl. Pengolahan Bawang No. 10',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => null,

            'jenis_psat' => $jenispsat2?->id,

            'nama_komoditas' => 'Kentang',
            'nama_latin' => 'Allium cepa',
            'negara_asal' => 'Indonesia',
            'merk_dagang' => 'Bawang Merah Bali',
            'jenis_kemasan' => 'Sakel',
            'ukuran_berat' => '10 kg per sakel',
            'klaim' => 'Pangan Lokal, Berkualitas Export',
            'foto_1' => env('APP_URL').'/'.'images/upload/register/bawang_7.jpg',
            'foto_2' => env('APP_URL').'/'.'images/upload/register/bawang_8.jpg',
            'foto_3' => env('APP_URL').'/'.'images/upload/register/bawang_9.jpg',
            'foto_4' => env('APP_URL').'/'.'images/upload/register/bawang_10.jpg',
            'foto_5' => env('APP_URL').'/'.'images/upload/register/bawang_11.jpg',
            'foto_6' => env('APP_URL').'/'.'images/upload/register/bawang_12.jpg',
            'file_nib' => env('APP_URL').'/'.'files/upload/register/NIB-BAWANG-012.pdf',
            'file_sppb' => env('APP_URL').'/'.'files/upload/register/SPPB-BAWANG-012.pdf',
            'file_izinedar_Psatpd' =>  env('APP_URL').'/'.'files/upload/register/IZIN-BAWANG-012.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-12-01',
            'tanggal_terakhir' => '2026-12-01',

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);
    }
}
