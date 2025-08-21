<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PengawasanTindakanLanjutan;
use App\Models\PengawasanTindakan;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PengawasanTindakanLanjutanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get reference data
        $users = User::pluck('id', 'email')->toArray();
        $tindakanRecords = PengawasanTindakan::pluck('id')->toArray();

        // Sample pengawasan tindakan lanjutan data
        $tindakanLanjutanData = [
            [
                'id' => Str::uuid(),
                'pengawasan_tindakan_id' => $tindakanRecords[0] ?? null,
                'user_id_pic' => $users['supervisor@panganaman.my.id'] ?? null,
                'tindak_lanjut' => 'Monitoring telah dilakukan dan hasilnya menunjukkan peningkatan kualitas.',
                'status' => 'SELESAI',
                'is_active' => true,
                'created_by' => $users['admin@panganaman.my.id'] ?? null,
                'updated_by' => $users['admin@panganaman.my.id'] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'pengawasan_tindakan_id' => $tindakanRecords[1] ?? null,
                'user_id_pic' => $users['operator@panganaman.my.id'] ?? null,
                'tindak_lanjut' => 'Perbaikan sanitasi telah selesai dilakukan, menunggu verifikasi dari supervisor.',
                'status' => 'PROSES',
                'is_active' => true,
                'created_by' => $users['supervisor@panganaman.my.id'] ?? null,
                'updated_by' => $users['supervisor@panganaman.my.id'] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'pengawasan_tindakan_id' => $tindakanRecords[2] ?? null,
                'user_id_pic' => $users['user@panganaman.my.id'] ?? null,
                'tindak_lanjut' => 'Evaluasi bulanan telah selesai dilakukan, tidak ada masalah signifikan.',
                'status' => 'SELESAI',
                'is_active' => true,
                'created_by' => $users['operator@panganaman.my.id'] ?? null,
                'updated_by' => $users['operator@panganaman.my.id'] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'pengawasan_tindakan_id' => $tindakanRecords[3] ?? null,
                'user_id_pic' => $users['kantorjabar@panganaman.my.id'] ?? null,
                'tindak_lanjut' => 'Dokumen pelabelan sedang dalam proses pengumpulan dan pengecekan.',
                'status' => 'PROSES',
                'is_active' => true,
                'created_by' => $users['user@panganaman.my.id'] ?? null,
                'updated_by' => $users['user@panganaman.my.id'] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'pengawasan_tindakan_id' => $tindakanRecords[4] ?? null,
                'user_id_pic' => $users['kantorjateng@panganaman.my.id'] ?? null,
                'tindak_lanjut' => 'Kalibrasi alat laboratorium telah selesai dilakukan, semua dalam kondisi baik.',
                'status' => 'SELESAI',
                'is_active' => true,
                'created_by' => $users['kantorjatim@panganaman.my.id'] ?? null,
                'updated_by' => $users['kantorjatim@panganaman.my.id'] ?? null,
            ],
        ];

        // Insert pengawasan tindakan lanjutan data
        foreach ($tindakanLanjutanData as $data) {
            PengawasanTindakanLanjutan::create($data);
        }
    }
}
