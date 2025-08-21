<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PengawasanTindakanPic;
use App\Models\PengawasanTindakan;
use App\Models\User;
use Illuminate\Support\Str;

class PengawasanTindakanPicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get reference data
        $users = User::pluck('id', 'email')->toArray();
        $tindakanRecords = PengawasanTindakan::pluck('id')->toArray();

        // Sample pengawasan tindakan pic data
        // This table links tindakan records to PIC (Person In Charge) users
        $picData = [
            // PIC for Tindakan 1
            [
                'tindakan_id' => $tindakanRecords[0] ?? null,
                'pic_id' => $users['supervisor@panganaman.my.id'] ?? null,
            ],
            [
                'tindakan_id' => $tindakanRecords[0] ?? null,
                'pic_id' => $users['operator@panganaman.my.id'] ?? null,
            ],

            // PIC for Tindakan 2
            [
                'tindakan_id' => $tindakanRecords[1] ?? null,
                'pic_id' => $users['operator@panganaman.my.id'] ?? null,
            ],
            [
                'tindakan_id' => $tindakanRecords[1] ?? null,
                'pic_id' => $users['user@panganaman.my.id'] ?? null,
            ],

            // PIC for Tindakan 3
            [
                'tindakan_id' => $tindakanRecords[2] ?? null,
                'pic_id' => $users['user@panganaman.my.id'] ?? null,
            ],

            // PIC for Tindakan 4
            [
                'tindakan_id' => $tindakanRecords[3] ?? null,
                'pic_id' => $users['kantorjabar@panganaman.my.id'] ?? null,
            ],
            [
                'tindakan_id' => $tindakanRecords[3] ?? null,
                'pic_id' => $users['kantorjatim@panganaman.my.id'] ?? null,
            ],

            // PIC for Tindakan 5
            [
                'tindakan_id' => $tindakanRecords[4] ?? null,
                'pic_id' => $users['kantorjateng@panganaman.my.id'] ?? null,
            ],
            [
                'tindakan_id' => $tindakanRecords[4] ?? null,
                'pic_id' => $users['kantorjabar@panganaman.my.id'] ?? null,
            ],
        ];

        // Insert pengawasan tindakan pic data
        foreach ($picData as $data) {
            PengawasanTindakanPic::create($data);
        }
    }
}
