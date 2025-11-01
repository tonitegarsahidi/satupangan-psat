<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PengawasanItem;
use App\Models\Pengawasan;
use App\Models\MasterBahanPanganSegar;
use App\Models\MasterCemaranMikroba;
use App\Models\MasterCemaranMikrotoksin;
use App\Models\MasterCemaranPestisida;
use App\Models\MasterCemaranLogamBerat;
use Illuminate\Support\Str;

class PengawasanItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing pengawasan records and master bahan pangan segar
        $pengawasanIds = Pengawasan::pluck('id')->toArray();


        $pengawasanItemTypes = config('pengawasan.pengawasan_item_types');

        if (empty($pengawasanIds)) {
            $this->command->info('Skipping PengawasanItemSeeder: No Pengawasan records found.');
            return;
        }

        // Get cemaran data
        $mikrobaIds = MasterCemaranMikroba::pluck('id')->toArray();
        $mikrotoksinIds = MasterCemaranMikrotoksin::pluck('id')->toArray();
        $pestisidaIds = MasterCemaranPestisida::pluck('id')->toArray();
        $logamBeratIds = MasterCemaranLogamBerat::pluck('id')->toArray();

        if (empty($mikrobaIds) || empty($mikrotoksinIds) || empty($pestisidaIds) || empty($logamBeratIds)) {
            $this->command->info('Skipping PengawasanItemSeeder: No Cemaran records found.');
            return;
        }

        // Define lab test configurations
        $labTestConfigs = [
            [
                'type' => 'mikroba',
                'ids' => $mikrobaIds,
                'unit' => 'CFU/g',
                'name_prefix' => 'Uji Mikroba: ',
                'parameter_prefix' => 'Analisis: ',
                'max_value' => 100000, // Max for TVC
            ],
            [
                'type' => 'mikrotoksin',
                'ids' => $mikrotoksinIds,
                'unit' => 'µg/kg',
                'name_prefix' => 'Uji Mikrotoksin: ',
                'parameter_prefix' => 'Analisis: ',
                'max_value' => 20, // Max for Aflatoxin
            ],
            [
                'type' => 'pestisida',
                'ids' => $pestisidaIds,
                'unit' => 'mg/kg',
                'name_prefix' => 'Uji Pestisida: ',
                'parameter_prefix' => 'Analisis: ',
                'max_value' => 1, // Max for common pesticides
            ],
            [
                'type' => 'logam_berat',
                'ids' => $logamBeratIds,
                'unit' => 'mg/kg',
                'name_prefix' => 'Uji Logam Berat: ',
                'parameter_prefix' => 'Analisis: ',
                'max_value' => 0.3, // Max for Pb
            ],
        ];

        $pengawasanItems = [];

        // Define test names and parameters for rapid type
        $rapidTestOptions = [
            ['name' => 'Rapid Test Aflatoksin', 'parameter' => 'Deteksi Aflatoksin B1'],
            ['name' => 'Rapid Test Logam Berat', 'parameter' => 'Deteksi Logam Berat (Pb, Cd, Hg)'],
            ['name' => 'Rapid Test Mikroba', 'parameter' => 'Deteksi Total Mikroba (TVC)'],
            ['name' => 'Rapid Test Pestisida', 'parameter' => 'Deteksi Sisa Pestisida Organofosfat'],
            ['name' => 'Uji Visual', 'parameter' => 'Pemeriksaan Kondisi Fisik'],
            ['name' => 'Uji Bau', 'parameter' => 'Pemeriksaan Kualitas Bau'],
            ['name' => 'Rapid Test Formalin', 'parameter' => 'Deteksi Formaldehida'],
            ['name' => 'Rapid Test Bleaching Chlorine', 'parameter' => 'Deteksi Sodium Hypochlorite'],
        ];

        foreach ($pengawasanIds as $pengawasanId) {


            // Get the specific produk_psat_id values from Pengawasan records
            $produkPsatId = Pengawasan::where('id', $pengawasanId)->first();


            // Generate 0-6 rapid type items
            $numRapidItems = rand(0, 6);
            for ($i = 0; $i < $numRapidItems; $i++) {
                // Make more than 80% negative
                $isPositif = (rand(1, 100) > 80);
                $isMemenuhiSyarat = !$isPositif; // If positive, then does not meet requirements

                $selectedTest = $rapidTestOptions[array_rand($rapidTestOptions)];

                $pengawasanItems[] = [
                    'id' => Str::uuid(),
                    'pengawasan_id' => $pengawasanId,
                    'type' => 'rapid',
                    'test_name' => $selectedTest['name'],
                    'test_parameter' => $selectedTest['parameter'],
                    'komoditas_id' => $produkPsatId["produk_psat_id"],
                    'value_numeric' => null,
                    'value_string' => $isPositif ? 'Positif' : 'Negatif',
                    'value_unit' => null,
                    'is_positif' => $isPositif,
                    'is_memenuhisyarat' => $isMemenuhiSyarat,
                    'keterangan' => 'Keterangan untuk rapid item ' . ($i + 1),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Generate 0-4 lab type items
            $numLabItems = rand(0, 4);
            for ($i = 0; $i < $numLabItems; $i++) {
                $config = $labTestConfigs[array_rand($labTestConfigs)];
                $cemaranId = $config['ids'][array_rand($config['ids'])];
                $isMemenuhiSyarat = (rand(1, 100) > 20); // 80% chance to meet requirements
                $isPositif = !$isMemenuhiSyarat; // If it meets requirements, it's not positive

                // Generate a value that is likely to be within limits if it meets requirements
                if ($isMemenuhiSyarat) {
                    $valueNumeric = (rand(1, intval($config['max_value'] * 0.8))) / 100; // Value is 80% below max
                } else {
                    $valueNumeric = (rand(intval($config['max_value'] * 0.8), intval($config['max_value'] * 2))) / 100; // Value is above max
                }

                // Get the cemaran model for the name
                $cemaranModel = null;
                switch ($config['type']) {
                    case 'mikroba':
                        $cemaranModel = MasterCemaranMikroba::find($cemaranId);
                        break;
                    case 'mikrotoksin':
                        $cemaranModel = MasterCemaranMikrotoksin::find($cemaranId);
                        break;
                    case 'pestisida':
                        $cemaranModel = MasterCemaranPestisida::find($cemaranId);
                        break;
                    case 'logam_berat':
                        $cemaranModel = MasterCemaranLogamBerat::find($cemaranId);
                        break;
                }

                $pengawasanItems[] = [
                    'id' => Str::uuid(),
                    'pengawasan_id' => $pengawasanId,
                    'type' => 'lab',
                    'test_name' => $config['name_prefix'] . ($cemaranModel ? $cemaranModel->nama_cemaran_mikroba ?? $cemaranModel->nama_cemaran_mikrotoksin ?? $cemaranModel->nama_cemaran_pestisida ?? $cemaranModel->nama_cemaran_logam_berat : 'Unknown'),
                    'test_parameter' => $config['parameter_prefix'] . ($cemaranModel ? $cemaranModel->nama_cemaran_mikroba ?? $cemaranModel->nama_cemaran_mikrotoksin ?? $cemaranModel->nama_cemaran_pestisida ?? $cemaranModel->nama_cemaran_logam_berat : 'Unknown'),
                    'komoditas_id' => $produkPsatId["produk_psat_id"],
                    'value_numeric' => $valueNumeric,
                    'value_string' => null,
                    'value_unit' => $config['unit'],
                    'is_positif' => $isPositif,
                    'is_memenuhisyarat' => $isMemenuhiSyarat,
                    'keterangan' => 'Keterangan untuk lab item ' . ($i + 1),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert data into the database
        foreach ($pengawasanItems as $item) {
            PengawasanItem::create($item);
        }

        $this->command->info('PengawasanItemSeeder completed successfully!');
    }
}
