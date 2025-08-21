<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PengawasanTindakan;
use App\Models\PengawasanRekap;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PengawasanTindakanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get reference data
        $users = User::pluck('id', 'email')->toArray();
        $rekapRecords = PengawasanRekap::pluck('id')->toArray();

        // Sample pengawasan tindakan data
        $tindakanData = [
            [
                'id' => Str::uuid(),
                'pengawasan_rekap_id' => $rekapRecords[0] ?? null,
                'user_id_pimpinan' => $users['admin@panganaman.my.id'] ?? null,
                'tindak_lanjut' => 'Melakukan monitoring berkala untuk memastikan kualitas produk terjaga.',
                'status' => 'SELESAI',
                'pic_tindakan_ids' => json_encode([
                    $users['supervisor@panganaman.my.id'] ?? null,
                    $users['operator@panganaman.my.id'] ?? null
                ]),
                'is_active' => true,
                'created_by' => $users['admin@panganaman.my.id'] ?? null,
                'updated_by' => $users['admin@panganaman.my.id'] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'pengawasan_rekap_id' => $rekapRecords[1] ?? null,
                'user_id_pimpinan' => $users['supervisor@panganaman.my.id'] ?? null,
                'tindak_lanjut' => 'Segera melakukan perbaikan sanitasi dan lakukan pelatihan karyawan.',
                'status' => 'PROSES',
                'pic_tindakan_ids' => json_encode([
                    $users['operator@panganaman.my.id'] ?? null,
                    $users['user@panganaman.my.id'] ?? null
                ]),
                'is_active' => true,
                'created_by' => $users['supervisor@panganaman.my.id'] ?? null,
                'updated_by' => $users['supervisor@panganaman.my.id'] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'pengawasan_rekap_id' => $rekapRecords[2] ?? null,
                'user_id_pimpinan' => $users['operator@panganaman.my.id'] ?? null,
                'tindak_lanjut' => 'Mempertahankan standar operasional yang ada dan lakukan evaluasi bulanan.',
                'status' => 'SELESAI',
                'pic_tindakan_ids' => json_encode([
                    $users['user@panganaman.my.id'] ?? null
                ]),
                'is_active' => true,
                'created_by' => $users['operator@panganaman.my.id'] ?? null,
                'updated_by' => $users['operator@panganaman.my.id'] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'pengawasan_rekap_id' => $rekapRecords[3] ?? null,
                'user_id_pimpinan' => $users['user@panganaman.my.id'] ?? null,
                'tindak_lanjut' => 'Melengkapi semua dokumen pelabelan sesuai standar yang berlaku.',
                'status' => 'PROSES',
                'pic_tindakan_ids' => json_encode([
                    $users['kantorjabar@panganaman.my.id'] ?? null,
                    $users['kantorjatim@panganaman.my.id'] ?? null
                ]),
                'is_active' => true,
                'created_by' => $users['user@panganaman.my.id'] ?? null,
                'updated_by' => $users['user@panganaman.my.id'] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'pengawasan_rekap_id' => $rekapRecords[4] ?? null,
                'user_id_pimpinan' => $users['kantorjatim@panganaman.my.id'] ?? null,
                'tindak_lanjut' => 'Terus mempertahankan kualitas laboratorium dan lakukan kalibrasi rutin.',
                'status' => 'SELESAI',
                'pic_tindakan_ids' => json_encode([
                    $users['kantorjateng@panganaman.my.id'] ?? null,
                    $users['kantorjabar@panganaman.my.id'] ?? null
                ]),
                'is_active' => true,
                'created_by' => $users['kantorjatim@panganaman.my.id'] ?? null,
                'updated_by' => $users['kantorjatim@panganaman.my.id'] ?? null,
            ],
        ];

        // Insert pengawasan tindakan data
        foreach ($tindakanData as $data) {
            PengawasanTindakan::create($data);
        }
    }
}
