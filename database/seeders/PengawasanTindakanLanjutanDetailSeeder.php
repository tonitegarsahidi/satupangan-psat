<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PengawasanTindakanLanjutanDetail;
use App\Models\PengawasanTindakanLanjutan;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PengawasanTindakanLanjutanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get reference data
        $users = User::pluck('id', 'email')->toArray();
        $tindakanLanjutanRecords = PengawasanTindakanLanjutan::pluck('id')->toArray();

        // Sample pengawasan tindakan lanjutan detail data
        $tindakanLanjutanDetailData = [
            [
                'id' => Str::uuid(),
                'pengawasan_tindakan_lanjutan_id' => $tindakanLanjutanRecords[0] ?? null,
                'message' => 'Pemeriksaan telah dilakukan dan hasilnya memenuhi standar.',
                'is_active' => true,
                'created_by' => $users['admin@panganaman.my.id'] ?? null,
                'updated_by' => $users['admin@panganaman.my.id'] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'pengawasan_tindakan_lanjutan_id' => $tindakanLanjutanRecords[1] ?? null,
                'message' => 'Tindakan perbaikan sedang dalam proses pengawasan.',
                'is_active' => true,
                'created_by' => $users['supervisor@panganaman.my.id'] ?? null,
                'updated_by' => $users['supervisor@panganaman.my.id'] ?? null,
            ],
            [
                'id' => Str::uuid(),
                'pengawasan_tindakan_lanjutan_id' => $tindakanLanjutanRecords[2] ?? null,
                'message' => 'Evaluasi telah selesai, tidak ada temuan baru.',
                'is_active' => true,
                'created_by' => $users['operator@panganaman.my.id'] ?? null,
                'updated_by' => $users['operator@panganaman.my.id'] ?? null,
            ],
        ];

        // Insert pengawasan tindakan lanjutan detail data
        foreach ($tindakanLanjutanDetailData as $data) {
            PengawasanTindakanLanjutanDetail::create($data);
        }
    }
}
