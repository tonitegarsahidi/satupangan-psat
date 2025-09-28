<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PengawasanTindakanLanjutanDetail;
use App\Models\PengawasanTindakanLanjutan;
use App\Models\PengawasanTindakan;
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
        $tindakanLanjutanRecords = PengawasanTindakanLanjutan::all();

        // Get user IDs from PengawasanTindakanLanjutan for PIC
        $picUserIds = $tindakanLanjutanRecords->pluck('user_id_pic')->unique()->filter()->values()->toArray();

        // Sample pengawasan tindakan lanjutan detail data templates
        $detailTemplates = [
            'Pemeriksaan telah dilakukan dan hasilnya memenuhi standar.',
            'Tindakan perbaikan sedang dalam proses pengawasan.',
            'Evaluasi telah selesai, tidak ada temuan baru.',
            'Dokumen telah diperbarui sesuai standar yang berlaku.',
            'Monitoring rutin telah selesai dilakukan.',
            'Pelatihan karyawan telah diselenggarakan.',
            'Kalibrasi alat telah dilakukan dan dalam kondisi baik.',
            'Verifikasi dokumen sedang dalam proses.',
        ];

        // Generate pengawasan tindakan lanjutan detail data with 2-5 entries per lanjutan
        $tindakanLanjutanDetailData = [];

        foreach ($tindakanLanjutanRecords as $lanjutan) {
            // Create 2-5 detail entries for each lanjutan
            $entriesCount = rand(2, 5);

            for ($i = 0; $i < $entriesCount; $i++) {
                $template = $detailTemplates[array_rand($detailTemplates)];

                // Use specific user IDs instead of random selection
                // Get pimpinan user ID from the related PengawasanTindakan
                $pimpinanUserId = $lanjutan->tindakan->user_id_pimpinan;

                // Use specific user IDs - prioritize PIC user, fallback to pimpinan
                $availableUserIds = array_filter([$lanjutan->user_id_pic, $pimpinanUserId]);
                $userId = !empty($availableUserIds) ? $availableUserIds[0] : $pimpinanUserId;

                $tindakanLanjutanDetailData[] = [
                    'id' => Str::uuid(),
                    'pengawasan_tindakan_lanjutan_id' => $lanjutan->id,
                    'user_id' => $userId,
                    'message' => $template,
                    'is_active' => true,
                    'created_by' => $userId,
                    'updated_by' => $userId,
                ];
            }
        }

        // Insert pengawasan tindakan lanjutan detail data
        foreach ($tindakanLanjutanDetailData as $data) {
            PengawasanTindakanLanjutanDetail::create($data);
        }
    }
}
