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
        $tindakanRecords = PengawasanTindakan::all();

        // Get user IDs from PengawasanTindakan for pimpinan
        $pimpinanUserIds = $tindakanRecords->pluck('user_id_pimpinan')->unique()->filter()->values()->toArray();

        // Sample pengawasan tindakan lanjutan data templates
        $tindakanLanjutanTemplates = [
            [
                'tindak_lanjut' => 'Monitoring telah dilakukan dan hasilnya menunjukkan peningkatan kualitas.',
                'status' => 'SELESAI',
            ],
            [
                'tindak_lanjut' => 'Perbaikan sanitasi telah selesai dilakukan, menunggu verifikasi dari supervisor.',
                'status' => 'PROSES',
            ],
            [
                'tindak_lanjut' => 'Evaluasi bulanan telah selesai dilakukan, tidak ada masalah signifikan.',
                'status' => 'SELESAI',
            ],
        ];

        // Generate pengawasan tindakan lanjutan data with 2-3 entries per tindakan
        $tindakanLanjutanData = [];
        $picUserIds = [
            $users['supervisor@panganaman.my.id'] ?? null,
            $users['operator@panganaman.my.id'] ?? null,
            $users['user@panganaman.my.id'] ?? null,
            $users['kantorjabar@panganaman.my.id'] ?? null,
            $users['kantorjateng@panganaman.my.id'] ?? null,
            $users['kantorjatim@panganaman.my.id'] ?? null,
        ];

        foreach ($tindakanRecords as $index => $tindakan) {
            // Create 2-3 lanjutan entries for each tindakan
            $entriesCount = rand(2, 3);

            for ($i = 0; $i < $entriesCount; $i++) {
                $template = $tindakanLanjutanTemplates[array_rand($tindakanLanjutanTemplates)];
                $randomPicUserId = $picUserIds[array_rand(array_filter($picUserIds))];

                $tindakanLanjutanData[] = [
                    'id' => Str::uuid(),
                    'pengawasan_tindakan_id' => $tindakan->id,
                    'user_id_pic' => $randomPicUserId,
                    'tindak_lanjut' => $template['tindak_lanjut'],
                    'status' => $template['status'],
                    'is_active' => true,
                    'created_by' => $randomPicUserId,
                    'updated_by' => $randomPicUserId,
                ];
            }
        }

        // Insert pengawasan tindakan lanjutan data
        foreach ($tindakanLanjutanData as $data) {
            PengawasanTindakanLanjutan::create($data);
        }
    }
}
