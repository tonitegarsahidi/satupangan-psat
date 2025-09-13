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
        $provinciUsers = [
            'Jawa Barat' => $users['kantorjabar@panganaman.my.id'] ?? null,
            'Jawa Tengah' => $users['kantorjateng@panganaman.my.id'] ?? null,
            'Jawa Timur' => $users['kantorjatim@panganaman.my.id'] ?? null,
            'Kewenangan Pusat' => $users['kantorpusat@panganaman.my.id'] ?? null,
        ];

        // Get all pengawasan rekap records with province information
        $rekapRecords = PengawasanRekap::with('provinsi')->get();

        // Sample pengawasan tindakan data templates by province context
        $tindakanTemplatesByProvince = [
            'Jawa Barat' => [
                [
                    'user_id_pimpinan' => $provinciUsers['Jawa Barat'],
                    'tindak_lanjut' => 'Melakukan monitoring berkala untuk memastikan kualitas produk terjaga di wilayah Jawa Barat.',
                    'status' => 'SELESAI',
                    'pic_tindakan_ids' => [$provinciUsers['Jawa Barat'], $provinciUsers['Jawa Tengah']],
                    'created_by' => $provinciUsers['Jawa Barat'],
                    'updated_by' => $provinciUsers['Jawa Barat'],
                ],
                [
                    'user_id_pimpinan' => $users['pimpinan@panganaman.my.id'] ?? $this->getRandomUser($users),
                    'tindak_lanjut' => 'Segera melakukan perbaikan sanitasi dan lakukan pelatihan karyawan di Jawa Barat.',
                    'status' => 'PROSES',
                    'pic_tindakan_ids' => [$provinciUsers['Jawa Barat'], $provinciUsers['Jawa Timur']],
                    'created_by' => $users['pimpinan@panganaman.my.id'] ?? $this->getRandomUser($users),
                    'updated_by' => $users['pimpinan@panganaman.my.id'] ?? $this->getRandomUser($users),
                ],
            ],
            'Jawa Tengah' => [
                [
                    'user_id_pimpinan' => $provinciUsers['Jawa Tengah'],
                    'tindak_lanjut' => 'Mempertahankan standar operasional yang ada dan lakukan evaluasi bulanan di Jawa Tengah.',
                    'status' => 'SELESAI',
                    'pic_tindakan_ids' => [$provinciUsers['Jawa Tengah'], $provinciUsers['Jawa Barat']],
                    'created_by' => $provinciUsers['Jawa Tengah'],
                    'updated_by' => $provinciUsers['Jawa Tengah'],
                ],
                [
                    'user_id_pimpinan' => $users['pimpinan@panganaman.my.id'] ?? $this->getRandomUser($users),
                    'tindak_lanjut' => 'Melengkapi semua dokumen pelabelan sesuai standar yang berlaku di Jawa Tengah.',
                    'status' => 'PROSES',
                    'pic_tindakan_ids' => [$provinciUsers['Jawa Tengah'], $provinciUsers['Jawa Timur']],
                    'created_by' => $users['pimpinan@panganaman.my.id'] ?? $this->getRandomUser($users),
                    'updated_by' => $users['pimpinan@panganaman.my.id'] ?? $this->getRandomUser($users),
                ],
            ],
            'Jawa Timur' => [
                [
                    'user_id_pimpinan' => $provinciUsers['Jawa Timur'],
                    'tindak_lanjut' => 'Terus mempertahankan kualitas laboratorium dan lakukan kalibrasi rutin di Jawa Timur.',
                    'status' => 'SELESAI',
                    'pic_tindakan_ids' => [$provinciUsers['Jawa Timur'], $provinciUsers['Jawa Tengah']],
                    'created_by' => $provinciUsers['Jawa Timur'],
                    'updated_by' => $provinciUsers['Jawa Timur'],
                ],
                [
                    'user_id_pimpinan' => $users['pimpinan@panganaman.my.id'] ?? $this->getRandomUser($users),
                    'tindak_lanjut' => 'Melakukan peningkatan sistem pengawasan dan pengujian berkala di Jawa Timur.',
                    'status' => 'PROSES',
                    'pic_tindakan_ids' => [$provinciUsers['Jawa Timur'], $provinciUsers['Jawa Barat']],
                    'created_by' => $users['pimpinan@panganaman.my.id'] ?? $this->getRandomUser($users),
                    'updated_by' => $users['pimpinan@panganaman.my.id'] ?? $this->getRandomUser($users),
                ],
            ],
            'Kewenangan Pusat' => [
                [
                    'user_id_pimpinan' => $provinciUsers['Kewenangan Pusat'] ?? $users['pimpinan@panganaman.my.id'],
                    'tindak_lanjut' => 'Melakukan koordinasi nasional untuk standarisasi pengawasan pangan.',
                    'status' => 'SELESAI',
                    'pic_tindakan_ids' => [$provinciUsers['Kewenangan Pusat'], $provinciUsers['Jawa Barat'], $provinciUsers['Jawa Tengah']],
                    'created_by' => $provinciUsers['Kewenangan Pusat'] ?? $users['pimpinan@panganaman.my.id'],
                    'updated_by' => $provinciUsers['Kewenangan Pusat'] ?? $users['pimpinan@panganaman.my.id'],
                ],
                [
                    'user_id_pimpinan' => $users['pimpinan@panganaman.my.id'] ?? $this->getRandomUser($users),
                    'tindak_lanjut' => 'Segera melakukan harmonisasi regulasi dan standar nasional pengawasan.',
                    'status' => 'PROSES',
                    'pic_tindakan_ids' => [$provinciUsers['Kewenangan Pusat'], $provinciUsers['Jawa Timur']],
                    'created_by' => $users['pimpinan@panganaman.my.id'] ?? $this->getRandomUser($users),
                    'updated_by' => $users['pimpinan@panganaman.my.id'] ?? $this->getRandomUser($users),
                ],
            ],
        ];

        // Default template for unknown provinces
        $defaultTemplates = [
            [
                'user_id_pimpinan' => $users['pimpinan@panganaman.my.id'] ?? $this->getRandomUser($users),
                'tindak_lanjut' => 'Melakukan monitoring dan evaluasi berkala untuk memastikan kepatuhan standar pangan.',
                'status' => 'SELESAI',
                'pic_tindakan_ids' => array_filter($provinciUsers, fn($user) => $user !== null),
                'created_by' => $users['pimpinan@panganaman.my.id'] ?? $this->getRandomUser($users),
                'updated_by' => $users['pimpinan@panganaman.my.id'] ?? $this->getRandomUser($users),
            ],
        ];

        // Generate pengawasan tindakan data matched to available rekap records with province context
        $tindakanData = [];

        foreach ($rekapRecords as $rekap) {
            // Get province name from relationship
            $provinsiName = $rekap->provinsi ? $rekap->provinsi->nama_provinsi : 'Unknown';

            // Get appropriate template based on province
            if (isset($tindakanTemplatesByProvince[$provinsiName])) {
                $templates = $tindakanTemplatesByProvince[$provinsiName];
            } else {
                $templates = $defaultTemplates;
            }

            // Select template based on rekap status or randomly
            $templateIndex = $rekap->status === 'SELESAI' ? 0 : (count($templates) > 1 ? 1 : 0);
            $template = $templates[$templateIndex] ?? $templates[0];

            // Ensure PIC tindakan IDs are filtered for valid users
            $picTindakanIds = array_filter($template['pic_tindakan_ids'], fn($id) => $id !== null);

            $tindakanData[] = [
                'id' => Str::uuid(),
                'pengawasan_rekap_id' => $rekap->id,
                'user_id_pimpinan' => $template['user_id_pimpinan'] ?: $this->getRandomUser($users),
                'tindak_lanjut' => $template['tindak_lanjut'],
                'status' => $template['status'],
                'pic_tindakan_ids' => json_encode($picTindakanIds),
                'is_active' => true,
                'created_by' => $template['created_by'] ?: $this->getRandomUser($users),
                'updated_by' => $template['updated_by'] ?: $this->getRandomUser($users),
            ];
        }

        // Insert pengawasan tindakan data and update corresponding rekap records
        foreach ($tindakanData as $data) {
            $tindakan = PengawasanTindakan::create($data);

            // Update the corresponding rekap record with the tindakan_id
            PengawasanRekap::where('id', $data['pengawasan_rekap_id'])
                ->update(['tindakan_id' => $tindakan->id]);
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
