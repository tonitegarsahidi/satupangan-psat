<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RegisterIzinedarPsatpl;
use App\Models\Business;
use App\Models\User;
use App\Models\MasterProvinsi;
use App\Models\MasterKota;
use App\Models\MasterJenisPanganSegar;
use App\Models\MasterKelompokPangan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RegisterIzinedarPsatplSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $this->seedRegisterIzinedarPsatpl();
    }

    private function getKomoditasDetails(string $namaKomoditas): array
    {
        $details = [
            'Melon' => [
                'merk_dagang' => 'Melon Manis',
                'nama_latin' => 'Cucumis melo',
                'jenis_kemasan' => 'Jaring',
                'ukuran_berat' => '1.5 kg',
            ],
            'Kentang' => [
                'merk_dagang' => 'Kentang Super',
                'nama_latin' => 'Solanum tuberosum',
                'jenis_kemasan' => 'Karung',
                'ukuran_berat' => '5 kg',
            ],
            'Semangka' => [
                'merk_dagang' => 'Semangka Segar',
                'nama_latin' => 'Citrullus lanatus',
                'jenis_kemasan' => 'Loose',
                'ukuran_berat' => '3 kg',
            ],
            'Pisang' => [
                'merk_dagang' => 'Pisang Raja',
                'nama_latin' => 'Musa acuminata',
                'jenis_kemasan' => 'Tandan',
                'ukuran_berat' => '2 kg',
            ],
            'Alpukat' => [
                'merk_dagang' => 'Alpukat Mentega',
                'nama_latin' => 'Persea americana',
                'jenis_kemasan' => 'Loose',
                'ukuran_berat' => '0.3 kg',
            ],
            'Jeruk' => [
                'merk_dagang' => 'Jeruk Manis',
                'nama_latin' => 'Citrus sinensis',
                'jenis_kemasan' => 'Jaring',
                'ukuran_berat' => '1 kg',
            ],
            'Mangga' => [
                'merk_dagang' => 'Mangga Harum Manis',
                'nama_latin' => 'Mangifera indica',
                'jenis_kemasan' => 'Loose',
                'ukuran_berat' => '0.4 kg',
            ],
            'Durian' => [
                'merk_dagang' => 'Durian Montong',
                'nama_latin' => 'Durio zibethinus',
                'jenis_kemasan' => 'Loose',
                'ukuran_berat' => '2 kg',
            ],
            'Nanas' => [
                'merk_dagang' => 'Nanas Madu',
                'nama_latin' => 'Ananas comosus',
                'jenis_kemasan' => 'Loose',
                'ukuran_berat' => '1 kg',
            ],
            'Salak' => [
                'merk_dagang' => 'Salak Pondoh',
                'nama_latin' => 'Salacca zalacca',
                'jenis_kemasan' => 'Keranjang',
                'ukuran_berat' => '0.5 kg',
            ],
            'Markisa' => [
                'merk_dagang' => 'Markisa Ungu',
                'nama_latin' => 'Passiflora edulis',
                'jenis_kemasan' => 'Plastik',
                'ukuran_berat' => '0.2 kg',
            ],
            'Rambutan' => [
                'merk_dagang' => 'Rambutan Binjai',
                'nama_latin' => 'Nephelium lappaceum',
                'jenis_kemasan' => 'Ikat',
                'ukuran_berat' => '0.5 kg',
            ],
        ];

        return $details[$namaKomoditas] ?? [
            'merk_dagang' => $namaKomoditas . ' Brand',
            'nama_latin' => $namaKomoditas . ' Latin Name',
            'jenis_kemasan' => 'Kemasan Umum',
            'ukuran_berat' => '1 kg',
        ];
    }

   private function seedRegisterIzinedarPsatpl(): void
   {
        // Get the user with email pengusaha@panganaman.my.id
        $user = User::where('email', 'pengusaha@panganaman.my.id')->first();
        if (!$user) {
            $this->command->error('User with email pengusaha@panganaman.my.id not found. Please ensure the user exists before running this seeder.');
            return;
        }

        $userpetugas = User::where('email', 'kantorpusat@panganaman.my.id')->first();
        if (!$userpetugas) {
            $this->command->error('User with email kantorpusat@panganaman.my.id not found. Please ensure the user exists before running this seeder.');
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

        // Get Kewenangan Pusat provinsi and kota
        $kewenanganPusatProvinsi = MasterProvinsi::where('nama_provinsi', 'Kewenangan Pusat')->first();
        $kewenanganPusatKota = MasterKota::where('nama_kota', 'Kewenangan Pusat')->first();

        // Get a sample jenis_psat
        // Ensure there are at least two jenis psat records
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



        // Create sample data for register_izinedar_psatpl
        RegisterIzinedarPsatpl::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DIAJUKAN',
            'is_enabled' => true,
            'nomor_sppb' => 'REG-SPPB-DNGN-001',
            'nomor_izinedar_pl' => 'REG-IZINPL-MLN-001',

            // Unit usaha data
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha Melon',
            'alamat_unitusaha' => 'Jl. Melon Manis No. 1',
            'alamat_unitpenanganan' => 'Jl. Melon Manis No. 1',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => 'NIB-MELON-001',

            'jenis_psat' => $jenispsat1?->id,

            'nama_komoditas' => 'Melon',
            'nama_latin' => $this->getKomoditasDetails('Melon')['nama_latin'],
            'negara_asal' => 'India',
            'merk_dagang' => $this->getKomoditasDetails('Melon')['merk_dagang'],
            'jenis_kemasan' => $this->getKomoditasDetails('Melon')['jenis_kemasan'],
            'ukuran_berat' => $this->getKomoditasDetails('Melon')['ukuran_berat'],
            'klaim' => 'Segar Manis, Berkualitas Export',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/melon1.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/melon2.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/melon3.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/melon4.jpg',
            'foto_5' => null,
            'foto_6' => null,
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_izinedar_psatpl' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-01-01',
            'tanggal_terakhir' => $this->getRandomTanggalTerakhir(),

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create additional data for Kewenangan Pusat
        RegisterIzinedarPsatpl::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DIAJUKAN',
            'is_enabled' => true,
            'nomor_sppb' => 'REG-SPPB-KMSN-002',
            'nomor_izinedar_pl' => 'REG-IZINPL-KEWENANGAN-002',

            // Unit usaha data
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha Pusat',
            'alamat_unitusaha' => 'Jl. Kebon Sirih No. 50',
            'alamat_unitpenanganan' => 'Jl. Kebon Sirih No. 50',
            'provinsi_unitusaha' => $kewenanganPusatProvinsi?->id,
            'kota_unitusaha' => $kewenanganPusatKota?->id,
            'nib_unitusaha' => 'NIB-PUSAT-002',

            'jenis_psat' => $jenispsat1?->id,

            'nama_komoditas' => 'Kentang',
            'nama_latin' => $this->getKomoditasDetails('Kentang')['nama_latin'],
            'negara_asal' => 'Indonesia',
            'merk_dagang' => $this->getKomoditasDetails('Kentang')['merk_dagang'],
            'jenis_kemasan' => $this->getKomoditasDetails('Kentang')['jenis_kemasan'],
            'ukuran_berat' => $this->getKomoditasDetails('Kentang')['ukuran_berat'],
            'klaim' => 'Segar Manis, Kualitas Premium',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/mangga1.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/mangga2.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/mangga3.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/mangga4.jpg',
            'foto_5' => null,
            'foto_6' => null,
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_izinedar_psatpl' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-02-01',
            'tanggal_terakhir' => $this->getRandomTanggalTerakhir(),

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create third sample entry for Mangga
        RegisterIzinedarPsatpl::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DISETUJUI',
            'is_enabled' => true,
            'nomor_sppb' => 'REG-SPPB-MNG-023',
            'nomor_izinedar_pl' => 'REG-IZINPL-MNG-003',

            // Unit usaha data
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha Mangga',
            'alamat_unitusaha' => 'Jl. Mangga Manis No. 3',
            'alamat_unitpenanganan' => 'Jl. Mangga Manis No. 3',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => 'NIB-MNG-001',

            'jenis_psat' => $jenispsat1?->id,

            'nama_komoditas' => 'Mangga',
            'nama_latin' => $this->getKomoditasDetails('Mangga')['nama_latin'],
            'negara_asal' => 'Indonesia',
            'merk_dagang' => $this->getKomoditasDetails('Mangga')['merk_dagang'],
            'jenis_kemasan' => $this->getKomoditasDetails('Mangga')['jenis_kemasan'],
            'ukuran_berat' => $this->getKomoditasDetails('Mangga')['ukuran_berat'],
            'klaim' => 'Segar Manis, Kualitas Premium',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/mangga3.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/mangga4.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/mangga5.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/mangga6.jpg',
            'foto_5' => null,
            'foto_6' => null,
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_izinedar_psatpl' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-03-01',
            'tanggal_terakhir' => $this->getRandomTanggalTerakhir(),

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create fourth sample entry for Pisang
        RegisterIzinedarPsatpl::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DIAJUKAN',
            'is_enabled' => true,
            'nomor_sppb' => 'REG-SPPB-PSN-014',
            'nomor_izinedar_pl' => 'REG-IZINPL-PSN-004',

            // Unit usaha data
            'is_unitusaha' => false,
            'nama_unitusaha' => null,
            'alamat_unitusaha' => null,
            'alamat_unitpenanganan' => 'Jl. Pengolahan Pisang No. 4',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => null,

            'jenis_psat' => $jenispsat1?->id,

            'nama_komoditas' => 'Pisang',
            'nama_latin' => $this->getKomoditasDetails('Pisang')['nama_latin'],
            'negara_asal' => 'Indonesia',
            'merk_dagang' => $this->getKomoditasDetails('Pisang')['merk_dagang'],
            'jenis_kemasan' => $this->getKomoditasDetails('Pisang')['jenis_kemasan'],
            'ukuran_berat' => $this->getKomoditasDetails('Pisang')['ukuran_berat'],
            'klaim' => 'Pangan Lokal, Berkualitas Export',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/pisang1.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/pisang2.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/pisang3.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/pisang4.jpg',
            'foto_5' => null,
            'foto_6' => null,
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/NIB-PSN-004.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/SPPB-PSN-004.pdf',
            'file_izinedar_psatpl' =>  env('APP_URL').'/'.'files/upload/register/IZIN-PSN-004.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-04-01',
            'tanggal_terakhir' => $this->getRandomTanggalTerakhir(),

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create fifth sample entry for Semangka
        RegisterIzinedarPsatpl::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DISETUJUI',
            'is_enabled' => true,
            'nomor_sppb' => 'REG-SPPB-SMG-013',
            'nomor_izinedar_pl' => 'REG-IZINPL-SMG-005',

            // Unit usaha data
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha Semangka',
            'alamat_unitusaha' => 'Jl. Semangka Merah No. 5',
            'alamat_unitpenanganan' => 'Jl. Semangka Merah No. 5',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => 'NIB-SMG-001',

            'jenis_psat' => $jenispsat1?->id,

            'nama_komoditas' => 'Semangka',
            'nama_latin' => $this->getKomoditasDetails('Semangka')['nama_latin'],
            'negara_asal' => 'Indonesia',
            'merk_dagang' => $this->getKomoditasDetails('Semangka')['merk_dagang'],
            'jenis_kemasan' => $this->getKomoditasDetails('Semangka')['jenis_kemasan'],
            'ukuran_berat' => $this->getKomoditasDetails('Semangka')['ukuran_berat'],
            'klaim' => 'Pangan Lokal, Berkualitas Export',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/semangka1.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/semangka2.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/semangka3.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/semangka4.jpg',
            'foto_5' => null,
            'foto_6' => null,
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_izinedar_psatpl' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-05-01',
            'tanggal_terakhir' => $this->getRandomTanggalTerakhir(),

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create sixth sample entry for Jeruk
        RegisterIzinedarPsatpl::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DIAJUKAN',
            'is_enabled' => true,
            'nomor_sppb' => 'REG-SPPB-JRK-022',
            'nomor_izinedar_pl' => 'REG-IZINPL-JRK-006',

            // Unit usaha data
            'is_unitusaha' => false,
            'nama_unitusaha' => null,
            'alamat_unitusaha' => null,
            'alamat_unitpenanganan' => 'Jl. Pengolahan Jeruk No. 6',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => null,

            'jenis_psat' => $jenispsat1?->id,

            'nama_komoditas' => 'Jeruk',
            'nama_latin' => $this->getKomoditasDetails('Jeruk')['nama_latin'],
            'negara_asal' => 'Indonesia',
            'merk_dagang' => $this->getKomoditasDetails('Jeruk')['merk_dagang'],
            'jenis_kemasan' => $this->getKomoditasDetails('Jeruk')['jenis_kemasan'],
            'ukuran_berat' => $this->getKomoditasDetails('Jeruk')['ukuran_berat'],
            'klaim' => 'Pangan Lokal, Berkualitas Export',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/jeruk1.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/jeruk2.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/jeruk3.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/jeruk4.jpg',
            'foto_5' => null,
            'foto_6' => null,
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/NIB-JRK-006.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/SPPB-JRK-006.pdf',
            'file_izinedar_psatpl' =>  env('APP_URL').'/'.'files/upload/register/IZIN-JRK-006.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-06-01',
            'tanggal_terakhir' => $this->getRandomTanggalTerakhir(),

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create seventh sample entry for Alpukat
        RegisterIzinedarPsatpl::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DISETUJUI',
            'is_enabled' => true,
            'nomor_sppb' => 'REG-SPPB-ALP-021',
            'nomor_izinedar_pl' => 'REG-IZINPL-ALP-007',

            // Unit usaha data
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha Alpukat',
            'alamat_unitusaha' => 'Jl. Alpukat Hijau No. 7',
            'alamat_unitpenanganan' => 'Jl. Alpukat Hijau No. 7',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => 'NIB-ALP-001',

            'jenis_psat' => $jenispsat1?->id,

            'nama_komoditas' => 'Alpukat',
            'nama_latin' => $this->getKomoditasDetails('Alpukat')['nama_latin'],
            'negara_asal' => 'Indonesia',
            'merk_dagang' => $this->getKomoditasDetails('Alpukat')['merk_dagang'],
            'jenis_kemasan' => $this->getKomoditasDetails('Alpukat')['jenis_kemasan'],
            'ukuran_berat' => $this->getKomoditasDetails('Alpukat')['ukuran_berat'],
            'klaim' => 'Pangan Lokal, Berkualitas Export',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/alpukat1.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/alpukat2.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/alpukat3.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/alpukat4.jpg',
            'foto_5' => null,
            'foto_6' => null,
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_izinedar_psatpl' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-07-01',
            'tanggal_terakhir' => $this->getRandomTanggalTerakhir(),

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create eighth sample entry for Durian
        RegisterIzinedarPsatpl::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DIAJUKAN',
            'is_enabled' => true,
            'nomor_sppb' => 'REG-SPPB-DNGN-001',
            'nomor_izinedar_pl' => 'REG-IZINPL-DRN-008',

            // Unit usaha data
            'is_unitusaha' => false,
            'nama_unitusaha' => null,
            'alamat_unitusaha' => null,
            'alamat_unitpenanganan' => 'Jl. Pengolahan Durian No. 8',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => null,

            'jenis_psat' => $jenispsat1?->id,

            'nama_komoditas' => 'Durian',
            'nama_latin' => $this->getKomoditasDetails('Durian')['nama_latin'],
            'negara_asal' => 'Indonesia',
            'merk_dagang' => $this->getKomoditasDetails('Durian')['merk_dagang'],
            'jenis_kemasan' => $this->getKomoditasDetails('Durian')['jenis_kemasan'],
            'ukuran_berat' => $this->getKomoditasDetails('Durian')['ukuran_berat'],
            'klaim' => 'Raja Buah, Kualitas Super',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/durian1.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/durian2.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/durian3.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/durian4.jpg',
            'foto_5' => null,
            'foto_6' => null,
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/NIB-DRN-008.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/SPPB-DRN-008.pdf',
            'file_izinedar_psatpl' =>  env('APP_URL').'/'.'files/upload/register/IZIN-DRN-008.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-08-01',
            'tanggal_terakhir' => $this->getRandomTanggalTerakhir(),

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create ninth sample entry for Nanas
        RegisterIzinedarPsatpl::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DISETUJUI',
            'is_enabled' => true,
            'nomor_sppb' => 'REG-SPPB-DNGN-001',
            'nomor_izinedar_pl' => 'REG-IZINPL-NNS-009',

            // Unit usaha data
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha Nanas',
            'alamat_unitusaha' => 'Jl. Nanas Manis No. 9',
            'alamat_unitpenanganan' => 'Jl. Nanas Manis No. 9',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => 'NIB-NNS-001',

            'jenis_psat' => $jenispsat1?->id,

            'nama_komoditas' => 'Nanas',
            'nama_latin' => $this->getKomoditasDetails('Nanas')['nama_latin'],
            'negara_asal' => 'Indonesia',
            'merk_dagang' => $this->getKomoditasDetails('Nanas')['merk_dagang'],
            'jenis_kemasan' => $this->getKomoditasDetails('Nanas')['jenis_kemasan'],
            'ukuran_berat' => $this->getKomoditasDetails('Nanas')['ukuran_berat'],
            'klaim' => 'Pangan Lokal, Berkualitas Export',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/nanas1.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/nanas2.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/nanas3.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/nanas4.jpg',
            'foto_5' => null,
            'foto_6' => null,
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_izinedar_psatpl' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-09-01',
            'tanggal_terakhir' => $this->getRandomTanggalTerakhir(),

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create tenth sample entry for Salak
        RegisterIzinedarPsatpl::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DIAJUKAN',
            'is_enabled' => true,
            'nomor_sppb' => 'REG-SPPB-DNGN-001',
            'nomor_izinedar_pl' => 'REG-IZINPL-SLK-010',

            // Unit usaha data
            'is_unitusaha' => false,
            'nama_unitusaha' => null,
            'alamat_unitusaha' => null,
            'alamat_unitpenanganan' => 'Jl. Pengolahan Salak No. 10',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => null,

            'jenis_psat' => $jenispsat1?->id,

            'nama_komoditas' => 'Salak',
            'nama_latin' => $this->getKomoditasDetails('Salak')['nama_latin'],
            'negara_asal' => 'Indonesia',
            'merk_dagang' => $this->getKomoditasDetails('Salak')['merk_dagang'],
            'jenis_kemasan' => $this->getKomoditasDetails('Salak')['jenis_kemasan'],
            'ukuran_berat' => $this->getKomoditasDetails('Salak')['ukuran_berat'],
            'klaim' => 'Pangan Lokal, Berkualitas Export',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/salak1.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/salak2.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/salak3.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/salak4.jpg',
            'foto_5' => null,
            'foto_6' => null,
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/NIB-SLK-010.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/SPPB-SLK-010.pdf',
            'file_izinedar_psatpl' =>  env('APP_URL').'/'.'files/upload/register/IZIN-SLK-010.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-10-01',
            'tanggal_terakhir' => $this->getRandomTanggalTerakhir(),

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create eleventh sample entry for Markisa
        RegisterIzinedarPsatpl::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DISETUJUI',
            'is_enabled' => true,
            'nomor_sppb' => 'REG-SPPB-DNGN-001',
            'nomor_izinedar_pl' => 'REG-IZINPL-MKS-011',

            // Unit usaha data
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha Markisa',
            'alamat_unitusaha' => 'Jl. Markisa Kuning No. 11',
            'alamat_unitpenanganan' => 'Jl. Markisa Kuning No. 11',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => 'NIB-MKS-001',

            'jenis_psat' => $jenispsat1?->id,

            'nama_komoditas' => 'Markisa',
            'nama_latin' => $this->getKomoditasDetails('Markisa')['nama_latin'],
            'negara_asal' => 'Indonesia',
            'merk_dagang' => $this->getKomoditasDetails('Markisa')['merk_dagang'],
            'jenis_kemasan' => $this->getKomoditasDetails('Markisa')['jenis_kemasan'],
            'ukuran_berat' => $this->getKomoditasDetails('Markisa')['ukuran_berat'],
            'klaim' => 'Pangan Lokal, Berkualitas Export',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/markisa1.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/markisa2.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/markisa3.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/markisa4.jpg',
            'foto_5' => null,
            'foto_6' => null,
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',
            'file_izinedar_psatpl' =>  env('APP_URL').'/'.'files/upload/register/contohdokumen.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-11-01',
            'tanggal_terakhir' => $this->getRandomTanggalTerakhir(),

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create twelfth sample entry for Rambutan
        RegisterIzinedarPsatpl::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DIAJUKAN',
            'is_enabled' => true,
            'nomor_sppb' => 'REG-SPPB-DNGN-001',
            'nomor_izinedar_pl' => 'REG-IZINPL-RBT-012',

            // Unit usaha data
            'is_unitusaha' => false,
            'nama_unitusaha' => null,
            'alamat_unitusaha' => null,
            'alamat_unitpenanganan' => 'Jl. Pengolahan Rambutan No. 12',
            'provinsi_unitusaha' => $provinsi?->id,
            'kota_unitusaha' => $kota?->id,
            'nib_unitusaha' => null,

            'jenis_psat' => $jenispsat1?->id,

            'nama_komoditas' => 'Rambutan',
            'nama_latin' => $this->getKomoditasDetails('Rambutan')['nama_latin'],
            'negara_asal' => 'Indonesia',
            'merk_dagang' => $this->getKomoditasDetails('Rambutan')['merk_dagang'],
            'jenis_kemasan' => $this->getKomoditasDetails('Rambutan')['jenis_kemasan'],
            'ukuran_berat' => $this->getKomoditasDetails('Rambutan')['ukuran_berat'],
            'klaim' => 'Pangan Lokal, Berkualitas Export',
            'foto_1' =>  env('APP_URL').'/'.'images/upload/register/rambutan1.jpg',
            'foto_2' =>  env('APP_URL').'/'.'images/upload/register/rambutan2.jpg',
            'foto_3' =>  env('APP_URL').'/'.'images/upload/register/rambutan3.jpg',
            'foto_4' =>  env('APP_URL').'/'.'images/upload/register/rambutan4.jpg',
            'foto_5' => null,
            'foto_6' => null,
            'file_nib' =>  env('APP_URL').'/'.'files/upload/register/NIB-RBT-012.pdf',
            'file_sppb' =>  env('APP_URL').'/'.'files/upload/register/SPPB-RBT-012.pdf',
            'file_izinedar_psatpl' =>  env('APP_URL').'/'.'files/upload/register/IZIN-RBT-012.pdf',

            'okkp_penangungjawab' => $userpetugas->id,

            'tanggal_terbit' => '2025-12-01',
            'tanggal_terakhir' => $this->getRandomTanggalTerakhir(),

            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);
    }

   private function getRandomTanggalTerakhir(): string
   {
       $now = Carbon::now();
       $randomPercentage = rand(1, 100);

       if ($randomPercentage <= 10) { // 10% between 0-1 month
           $months = rand(0, 1);
           $days = rand(0, 30); // Max 30 days for a month
           return $now->copy()->addMonths($months)->addDays($days)->format('Y-m-d');
       } elseif ($randomPercentage <= 30) { // 20% between 1-2 months
           $months = rand(1, 2);
           $days = rand(0, 30);
           return $now->copy()->addMonths($months)->addDays($days)->format('Y-m-d');
       } else { // 70% between 2-24 months
           $months = rand(2, 24);
           $days = rand(0, 30);
           return $now->copy()->addMonths($months)->addDays($days)->format('Y-m-d');
       }
   }
}
