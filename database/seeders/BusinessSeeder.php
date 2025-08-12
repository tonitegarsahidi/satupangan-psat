<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BusinessSeeder extends Seeder
{
    public function run()
    {
        // Get user IDs for business users
        $user1 = DB::table('users')->where('email', 'pengusaha@panganaman.my.id')->first();
        $user2 = DB::table('users')->where('email', 'pengusaha2@panganaman.my.id')->first();

        // Get provinsi_id for Jawa Timur
        $provinsi = DB::table('master_provinsis')->where('nama_provinsi', 'Jawa Timur')->first();
        $provinsi_id = $provinsi ? $provinsi->id : null;

        // Get kota_id for Malang
        $kota = DB::table('master_kotas')->where('nama_kota', 'Kota Malang')->first();
        $kota_id = $kota ? $kota->id : null;

        $now = Carbon::now();

        $businesses = [
            [
                'id' => Str::uuid(),
                'user_id' => $user1 ? $user1->id : null,
                'nama_perusahaan' => 'PT Buah Internasional',
                'alamat_perusahaan' => 'Jl. Buah Segar No. 1',
                'jabatan_perusahaan' => 'Direktur',
                'nib' => '1234567890',
                'is_active' => true,
                'is_umkm' => false,
                'created_by' => 'seeder',
                'updated_by' => 'seeder',
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
                'provinsi_id' => $provinsi_id,
                'kota_id' => $kota_id,
            ],
            [
                'id' => Str::uuid(),
                'user_id' => $user2 ? $user2->id : null,
                'nama_perusahaan' => 'UD Mitra Tani',
                'alamat_perusahaan' => 'Jl. Brakseng Kebun No. 2',
                'jabatan_perusahaan' => 'Owner',
                'nib' => '0987654321',
                'is_active' => true,
                'is_umkm' => true,
                'created_by' => 'seeder',
                'updated_by' => 'seeder',
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
                'provinsi_id' => $provinsi_id,
                'kota_id' => $kota_id,
            ],
        ];

        DB::table('business')->insert($businesses);
    }
}
