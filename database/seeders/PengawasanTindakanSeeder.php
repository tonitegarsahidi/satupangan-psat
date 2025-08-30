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

        // Sample pengawasan tindakan data templates
        $tindakanTemplates = [
            [
                'user_id_pimpinan' => $users['pimpinan@panganaman.my.id'] ?? $this->getRandomUser($users),
                'tindak_lanjut' => 'Melakukan monitoring berkala untuk memastikan kualitas produk terjaga.',
                'status' => 'SELESAI',
                'pic_tindakan_ids' => [$users['kantorpusat@panganaman.my.id'], $users['kantorjatim@panganaman.my.id']],
                'created_by' => $users['pimpinan@panganaman.my.id'] ?? $this->getRandomUser($users),
                'updated_by' => $users['pimpinan@panganaman.my.id'] ?? $this->getRandomUser($users),
            ],
            [
                'user_id_pimpinan' => $users['kantorpusat@panganaman.my.id'] ?? $this->getRandomUser($users),
                'tindak_lanjut' => 'Segera melakukan perbaikan sanitasi dan lakukan pelatihan karyawan.',
                'status' => 'PROSES',
                'pic_tindakan_ids' => [$users['kantorjatim@panganaman.my.id'], $users['kantorjateng@panganaman.my.id']],
                'created_by' => $users['kantorpusat@panganaman.my.id'] ?? $this->getRandomUser($users),
                'updated_by' => $users['kantorpusat@panganaman.my.id'] ?? $this->getRandomUser($users),
            ],
            [
                'user_id_pimpinan' => $users['kantorjatim@panganaman.my.id'] ?? $this->getRandomUser($users),
                'tindak_lanjut' => 'Mempertahankan standar operasional yang ada dan lakukan evaluasi bulanan.',
                'status' => 'SELESAI',
                'pic_tindakan_ids' => [$users['kantorjateng@panganaman.my.id']],
                'created_by' => $users['kantorjatim@panganaman.my.id'] ?? $this->getRandomUser($users),
                'updated_by' => $users['kantorjatim@panganaman.my.id'] ?? $this->getRandomUser($users),
            ],
            [
                'user_id_pimpinan' => $users['kantorjateng@panganaman.my.id'] ?? $this->getRandomUser($users),
                'tindak_lanjut' => 'Melengkapi semua dokumen pelabelan sesuai standar yang berlaku.',
                'status' => 'PROSES',
                'pic_tindakan_ids' => [$users['kantorjabar@panganaman.my.id'], $users['kantorjatim@panganaman.my.id']],
                'created_by' => $users['kantorjateng@panganaman.my.id'] ?? $this->getRandomUser($users),
                'updated_by' => $users['kantorjateng@panganaman.my.id'] ?? $this->getRandomUser($users),
            ],
            [
                'user_id_pimpinan' => $users['kantorjatim@panganaman.my.id'] ?? $this->getRandomUser($users),
                'tindak_lanjut' => 'Terus mempertahankan kualitas laboratorium dan lakukan kalibrasi rutin.',
                'status' => 'SELESAI',
                'pic_tindakan_ids' => [$users['kantorjateng@panganaman.my.id'], $users['kantorjabar@panganaman.my.id']],
                'created_by' => $users['kantorjatim@panganaman.my.id'] ?? $this->getRandomUser($users),
                'updated_by' => $users['kantorjatim@panganaman.my.id'] ?? $this->getRandomUser($users),
            ],
        ];

        // Generate pengawasan tindakan data matched to available rekap records
        $tindakanData = [];
        $index = 0;
        foreach ($rekapRecords as $rekapId) {
            $templateIndex = $index % count($tindakanTemplates);
            $template = $tindakanTemplates[$templateIndex];

            $tindakanData[] = [
                'id' => Str::uuid(),
                'pengawasan_rekap_id' => $rekapId,
                'user_id_pimpinan' => $template['user_id_pimpinan'],
                'tindak_lanjut' => $template['tindak_lanjut'],
                'status' => $template['status'],
                'pic_tindakan_ids' => json_encode(array_filter($template['pic_tindakan_ids'], fn($id) => $id !== null)),
                'is_active' => true,
                'created_by' => $template['created_by'],
                'updated_by' => $template['updated_by'],
            ];

            $index++;
        }

        // Insert pengawasan tindakan data
        foreach ($tindakanData as $data) {
            PengawasanTindakan::create($data);
        }
    }

    /**
     * Get a random user ID from the users array
     */
    private function getRandomUser($users)
    {
        if (empty($users)) {
            return null;
        }
        $randomKey = array_rand($users);
        return $users[$randomKey];
    }
}
