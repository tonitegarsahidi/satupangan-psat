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
                'arahan_tindak_lanjut' => 'Lakukan monitoring rutin setiap minggu untuk memastikan kualitas produk terjaga.',
                'status' => 'SELESAI',
            ],
            [
                'arahan_tindak_lanjut' => 'Segera lakukan perbaikan sanitasi area produksi dan lapor hasilnya dalam 3 hari kerja.',
                'status' => 'PROSES',
            ],
            [
                'arahan_tindak_lanjut' => 'Lakukan evaluasi komprehensif sistem manajemen mutu pada akhir bulan ini.',
                'status' => 'SELESAI',
            ],
            [
                'arahan_tindak_lanjut' => 'Periksa kembali semua alat produksi dan pastikan semua terjaga dengan baik.',
                'status' => 'PROSES',
            ],
            [
                'arahan_tindak_lanjut' => 'Lakukan pelatihan standar operasional prosedur (SOP) bagi seluruh karyawan.',
                'status' => 'SELESAI',
            ],
            [
                'arahan_tindak_lanjut' => 'Lakukan investigasi menyeluruh mengenai penyebab kontaminasi dan laporkan temuan.',
                'status' => 'PROSES',
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
                    'arahan_tindak_lanjut' => $template['arahan_tindak_lanjut'],
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
