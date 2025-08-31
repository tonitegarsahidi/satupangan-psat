<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\LaporanPengaduan;
use App\Models\Workflow;
use App\Models\User;
use App\Models\MasterProvinsi;
use App\Models\MasterKota;
use App\Models\RoleMaster;
use App\Http\Controllers\LaporanPengaduanController;
use App\Http\Requests\LaporanPengaduan\LaporanPengaduanAddRequest;
use Illuminate\Http\Request;

class LaporanPengaduanSeeder extends Seeder
{
    public function run()
    {
        // Ensure default user exists for seeder and assignee
        $defaultUserEmail = 'user2@panganaman.my.id';
        $assigneeEmail = config('constant.LAPORAN_PENGADUAN_ASSIGNEE');

        $user = User::firstOrCreate(
            ['email' => $defaultUserEmail],
            [
                'name' => 'Default User',
                'password' => Hash::make('password'), // You might want a more secure default password
                'email_verified_at' => now(),
                'is_active' => true,
                'created_by' => 'seeder',
            ]
        );

        $assigneeUser = User::firstOrCreate(
            ['email' => $assigneeEmail],
            [
                'name' => 'Assignee User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
                'created_by' => 'seeder',
            ]
        );

        // Ensure default role exists and assign to users
        $roleUser = RoleMaster::where('role_code', 'ROLE_USER')->first();
        $roleAdmin = RoleMaster::where('role_code', 'ROLE_ADMIN')->first(); // Assuming an admin role for assignee

        $user->roles()->syncWithoutDetaching([$roleUser->id => ['id' => Str::uuid()]]);
        $assigneeUser->roles()->syncWithoutDetaching([$roleAdmin->id => ['id' => Str::uuid()]]);

        // Get all provinces
        $provinces = MasterProvinsi::all();

        // Ensure default kota exists for each province
        $kotasByProvince = [];
        foreach ($provinces as $province) {
            $kota = MasterKota::where('provinsi_id', $province->id)->first();
            if (!$kota) {
                // Create a default city for the province if none exists
                $kota = MasterKota::create([
                    'provinsi_id' => $province->id,
                    'nama_kota' => $province->nama_provinsi . ' Kota',
                    'is_active' => true,
                    'created_by' => 'seeder',
                ]);
            }
            $kotasByProvince[$province->id] = $kota;
        }

        $laporanController = new LaporanPengaduanController(
            app(\App\Services\LaporanPengaduanService::class),
            app(\App\Services\UserService::class)
        );

        // Sample laporan data templates
        $laporanTemplates = [
            [
                'nama_pelapor' => 'Budi Santoso',
                'nik_pelapor' => '1234567890123456',
                'nomor_telepon_pelapor' => '081234567890',
                'email_pelapor' => 'budi@example.com',
                'lokasi_kejadian' => 'Supermarket X, Jl. Merdeka No. 1',
                'isi_laporan' => 'Ditemukan cabe merah yang terindikasi jamur dijual di Supermarket X.',
                'tindak_lanjut_pertama' => 'Sudah dilaporkan ke pengelola supermarket.',
            ],
            [
                'nama_pelapor' => 'Siti Aminah',
                'nik_pelapor' => null,
                'nomor_telepon_pelapor' => null,
                'email_pelapor' => 'siti@example.com',
                'lokasi_kejadian' => 'Pasar Induk, Blok A',
                'isi_laporan' => 'Kemasan makanan impor ditemukan hanya menggunakan bahasa asing tanpa bahasa Indonesia.',
                'tindak_lanjut_pertama' => 'Petugas pasar sudah diberi tahu.',
            ],
            [
                'nama_pelapor' => 'Andi Wijaya',
                'nik_pelapor' => '9876543210987654',
                'nomor_telepon_pelapor' => '082112223333',
                'email_pelapor' => null,
                'lokasi_kejadian' => 'Toko Sembako Bu Sari',
                'isi_laporan' => 'Ditemukan produk susu kadaluarsa masih dipajang di rak penjualan.',
                'tindak_lanjut_pertama' => 'Penjual sudah diminta menarik produk dari rak.',
            ],
            [
                'nama_pelapor' => 'Rina Kartika',
                'nik_pelapor' => '5555566667778889',
                'nomor_telepon_pelapor' => '085678901234',
                'email_pelapor' => 'rina@example.com',
                'lokasi_kejadian' => 'Restoran Mewah, Jl. Sudirman No. 99',
                'isi_laporan' => 'Makanan tidak layak konsumsi menyebabkan keracunan setelah konsumsi.',
                'tindak_lanjut_pertama' => 'Sudah dilaporkan ke Dinas Kesehatan.',
            ],
            [
                'nama_pelapor' => 'Hendra Wijaya',
                'nik_pelapor' => '1111222233334444',
                'nomor_telepon_pelapor' => '089876543210',
                'email_pelapor' => 'hendra@example.com',
                'lokasi_kejadian' => 'Pasar Tradisional, Jl. Ahmad Yani',
                'isi_laporan' => 'Ditemukan daging tidak segar dengan bau tidak wajar.',
                'tindak_lanjut_pertama' => 'Kepala pasar sudah diberi tahu.',
            ],
            [
                'nama_pelapor' => 'Maya Putri',
                'nik_pelapor' => '6666777788889999',
                'nomor_telepon_pelapor' => '081234567891',
                'email_pelapor' => 'maya@example.com',
                'lokasi_kejadian' => 'Warung Makan Sederhana, Jl. Pemuda',
                'isi_laporan' => 'Kondisi ruangan tidak卫生 (tidak higienis) dan penataan ruang tidak memenuhi standar.',
                'tindak_lanjut_pertama' => 'Pemilik warung sudah diminta melakukan perbaikan.',
            ],
        ];

        $laporans = [];

        foreach ($provinces as $province) {
            $kota = $kotasByProvince[$province->id];

            // Create 2-3 laporans for each province
            $reportsForProvince = rand(2, 3);

            for ($i = 0; $i < $reportsForProvince; $i++) {
                // Convert UUID to a numeric value for template index calculation
                $provinceNumeric = hexdec(substr($province->id, 0, 8)); // Use first 8 characters of UUID
                $templateIndex = ($provinceNumeric + $i) % count($laporanTemplates);
                $template = $laporanTemplates[$templateIndex];

                $data = $template;

                // Modify some data for variety
                $data['nama_pelapor'] = $data['nama_pelapor'] . ' ' . $province->nama_provinsi;
                $data['lokasi_kejadian'] = $data['lokasi_kejadian'] . ', ' . $kota->nama_kota;

                $mockRequest = Request::create('/dummy-url', 'POST', $data);
                $mockRequest->merge([
                    'provinsi_id' => $province->id,
                    'kota_id' => $kota->id,
                    'user_id' => $user->id,
                ]);

                $laporanAddRequest = LaporanPengaduanAddRequest::createFromBase($mockRequest);
                $laporanAddRequest->setUserResolver(function () use ($user) {
                    return $user;
                });

                // Manually set the validator for the request
                $validator = \Illuminate\Support\Facades\Validator::make($laporanAddRequest->all(), $laporanAddRequest->rules());
                $laporanAddRequest->setValidator($validator);

                $laporan = $laporanController->store($laporanAddRequest);
                $laporans[] = $laporan;
            }
        }
    }
}
