<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PengawasanItem;
use App\Models\Pengawasan;
use App\Models\MasterBahanPanganSegar;
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
        $komoditasIds = MasterBahanPanganSegar::pluck('id')->toArray();
        $pengawasanItemTypes = config('pengawasan.pengawasan_item_types');

        if (empty($pengawasanIds) || empty($komoditasIds)) {
            $this->command->info('Skipping PengawasanItemSeeder: No Pengawasan or MasterBahanPanganSegar records found.');
            return;
        }

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
                    'komoditas_id' => $komoditasIds[array_rand($komoditasIds)],
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
                $isPositif = (bool) rand(0, 1);
                $isMemenuhiSyarat = (bool) rand(0, 1);
                $pengawasanItems[] = [
                    'id' => Str::uuid(),
                    'pengawasan_id' => $pengawasanId,
                    'type' => 'lab',
                    'test_name' => 'Lab Test ' . Str::random(5),
                    'test_parameter' => 'Uji Laboratorium Logam Berat',
                    'komoditas_id' => $komoditasIds[array_rand($komoditasIds)],
                    'value_numeric' => (rand(1, 1000) / 100), // Example: 1.00 to 10.00
                    'value_string' => null,
                    'value_unit' => ['mg/kg', 'ppm', 'ppb'][array_rand(['mg/kg', 'ppm', 'ppb'])],
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
