<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MasterProvinsi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class MasterProvinsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = [
            'Aceh',
            'Bali',
            'Bangka Belitung',
            'Banten',
            'Bengkulu',
            'DI Yogyakarta',
            'DKI Jakarta',
            'Gorontalo',
            'Jambi',
            'Jawa Barat',
            'Jawa Tengah',
            'Jawa Timur',
            'Kalimantan Barat',
            'Kalimantan Selatan',
            'Kalimantan Tengah',
            'Kalimantan Timur',
            'Kalimantan Utara',
            'Kepulauan Riau',
            'Kewenangan Pusat',
            'Lampung',
            'Maluku',
            'Maluku Utara',
            'Nusa Tenggara Barat',
            'Nusa Tenggara Timur',
            'Papua',
            'Papua Barat',
            'Riau',
            'Sulawesi Barat',
            'Sulawesi Selatan',
            'Sulawesi Tengah',
            'Sulawesi Tenggara',
            'Sulawesi Utara',
            'Sumatera Barat',
            'Sumatera Selatan',
            'Sumatera Utara',
        ];

        sort($provinces); // Sort alphabetically

        foreach ($provinces as $provinceName) {
            MasterProvinsi::create([
                'id' => Str::uuid(),
                'kode_provinsi' => $this->generateProvinceCode($provinceName),
                'nama_provinsi' => $provinceName,
                'is_active' => true,
                'created_by' => 'seeder',
            ]);
            Log::info("Seeding province: {$provinceName} with code: {$this->generateProvinceCode($provinceName)}");
        }
    }

    private function generateProvinceCode(string $provinceName): string
    {
        return match ($provinceName) {
            'Aceh' => 'ACEH',
            'Bali' => 'BALI',
            'Bangka Belitung' => 'BABEL',
            'Banten' => 'BANTEN',
            'Bengkulu' => 'BENGKULU',
            'DI Yogyakarta' => 'DIY',
            'DKI Jakarta' => 'DKI',
            'Gorontalo' => 'GORONTALO',
            'Jambi' => 'JAMBI',
            'Jawa Barat' => 'JABAR',
            'Jawa Tengah' => 'JATENG',
            'Jawa Timur' => 'JATIM',
            'Kalimantan Barat' => 'KALBAR',
            'Kalimantan Selatan' => 'KALSEL',
            'Kalimantan Tengah' => 'KALTENG',
            'Kalimantan Timur' => 'KALTIM',
            'Kalimantan Utara' => 'KALTARA',
            'Kepulauan Riau' => 'KEPRI',
            'Kewenangan Pusat' => 'KPUSAT',
            'Lampung' => 'LAMPUNG',
            'Maluku' => 'MALUKU',
            'Maluku Utara' => 'MALUT',
            'Nusa Tenggara Barat' => 'NTB',
            'Nusa Tenggara Timur' => 'NTT',
            'Papua' => 'PAPUA',
            'Papua Barat' => 'PABAR',
            'Riau' => 'RIAU',
            'Sulawesi Barat' => 'SULBAR',
            'Sulawesi Selatan' => 'SULSEL',
            'Sulawesi Tengah' => 'SULTENG',
            'Sulawesi Tenggara' => 'SULTRA',
            'Sulawesi Utara' => 'SULUT',
            'Sumatera Barat' => 'SUMBAR',
            'Sumatera Selatan' => 'SUMSEL',
            'Sumatera Utara' => 'SUMUT',
            default => Str::upper(Str::slug($provinceName, '')),
        };
    }
}
