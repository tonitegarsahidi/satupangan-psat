<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BusinessJenispsatSeeder extends Seeder
{
    public function run()
    {
        $jenispsats = DB::table('master_jenis_pangan_segars')->pluck('id')->toArray();
        $businesses = DB::table('business')->pluck('id')->toArray();
        $now = Carbon::now();

        $data = [];
        foreach ($businesses as $i => $business_id) {
            // Assign at least one jenispsat to each business
            if (isset($jenispsats[$i])) {
                $data[] = [
                    'id' => Str::uuid(),
                    'business_id' => $business_id,
                    'jenispsat_id' => $jenispsats[$i],
                    'is_active' => true,
                    'created_by' => 'seeder',
                    'updated_by' => 'seeder',
                    'created_at' => $now,
                    'updated_at' => $now,
                    'deleted_at' => null,
                ];
            } elseif (!empty($jenispsats)) {
                // If not enough jenispsat, just assign the first one
                $data[] = [
                    'id' => Str::uuid(),
                    'business_id' => $business_id,
                    'jenispsat_id' => $jenispsats[0],
                    'is_active' => true,
                    'created_by' => 'seeder',
                    'updated_by' => 'seeder',
                    'created_at' => $now,
                    'updated_at' => $now,
                    'deleted_at' => null,
                ];
            }
        }

        if (!empty($data)) {
            DB::table('business_jenispsat')->insert($data);
        }
    }
}
