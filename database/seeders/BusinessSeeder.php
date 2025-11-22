<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class BusinessSeeder extends Seeder
{
    public function run()
    {
        // Get user IDs for existing business users
        $user1 = DB::table('users')->where('email', 'pengusaha@panganaman.my.id')->first();
        $user2 = DB::table('users')->where('email', 'pengusaha2@panganaman.my.id')->first();

        // Create new users for additional businesses
        $user3_id = Str::uuid();
        DB::table('users')->insert([
            'id' => $user3_id,
            'name' => 'Budi Santoso',
            'email' => 'pengusaha3@panganaman.my.id',
            'password' => Hash::make('password123'),
            'is_active' => true,
            'email_verified_at' => Carbon::now(),
            'phone_number' => '081234567890',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $user4_id = Str::uuid();
        DB::table('users')->insert([
            'id' => $user4_id,
            'name' => 'Siti Nurhaliza',
            'email' => 'pengusaha4@panganaman.my.id',
            'password' => Hash::make('password123'),
            'is_active' => true,
            'email_verified_at' => Carbon::now(),
            'phone_number' => '081234567891',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $user5_id = Str::uuid();
        DB::table('users')->insert([
            'id' => $user5_id,
            'name' => 'Ahmad Wijaya',
            'email' => 'pengusaha5@panganaman.my.id',
            'password' => Hash::make('password123'),
            'is_active' => true,
            'email_verified_at' => Carbon::now(),
            'phone_number' => '081234567892',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $user6_id = Str::uuid();
        DB::table('users')->insert([
            'id' => $user6_id,
            'name' => 'Rina Marlina',
            'email' => 'pengusaha6@panganaman.my.id',
            'password' => Hash::make('password123'),
            'is_active' => true,
            'email_verified_at' => Carbon::now(),
            'phone_number' => '081234567893',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Get provinsi_id for Jawa Timur
        $provinsi = DB::table('master_provinsis')->where('nama_provinsi', 'Jawa Timur')->first();
        $provinsi_id = $provinsi ? $provinsi->id : null;

        // Get kota_id for Malang
        $kota = DB::table('master_kotas')->where('nama_kota', 'Kota Malang')->first();
        $kota_id = $kota ? $kota->id : null;

        // Get provinsi_id for Jawa Tengah and Jawa Barat
        $provinsi_jateng = DB::table('master_provinsis')->where('nama_provinsi', 'Jawa Tengah')->first();
        $provinsi_jabar = DB::table('master_provinsis')->where('nama_provinsi', 'Jawa Barat')->first();

        // Get kota_id for cities in Jawa Tengah and Jawa Barat
        $kota_semarang = DB::table('master_kotas')->where('nama_kota', 'Kota Semarang')->first();
        $kota_surakarta = DB::table('master_kotas')->where('nama_kota', 'Kota Surakarta')->first();
        $kota_bandung = DB::table('master_kotas')->where('nama_kota', 'Kota Bandung')->first();
        $kota_bogor = DB::table('master_kotas')->where('nama_kota', 'Kota Bogor')->first();

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
            // Pelaku Usaha dari Jawa Tengah
            [
                'id' => Str::uuid(),
                'user_id' => $user3_id,
                'nama_perusahaan' => 'CV Sari Segar Jaya',
                'alamat_perusahaan' => 'Jl. Ahmad Yani No. 45, Semarang',
                'jabatan_perusahaan' => 'Direktur Utama',
                'nib' => '1122334455',
                'is_active' => true,
                'is_umkm' => false,
                'created_by' => 'seeder',
                'updated_by' => 'seeder',
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
                'provinsi_id' => $provinsi_jateng ? $provinsi_jateng->id : null,
                'kota_id' => $kota_semarang ? $kota_semarang->id : null,
            ],
            [
                'id' => Str::uuid(),
                'user_id' => $user4_id,
                'nama_perusahaan' => 'UD Tani Makmur Solo',
                'alamat_perusahaan' => 'Jl. Slamet Riyadi No. 78, Surakarta',
                'jabatan_perusahaan' => 'Pemilik',
                'nib' => '5544332211',
                'is_active' => true,
                'is_umkm' => true,
                'created_by' => 'seeder',
                'updated_by' => 'seeder',
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
                'provinsi_id' => $provinsi_jateng ? $provinsi_jateng->id : null,
                'kota_id' => $kota_surakarta ? $kota_surakarta->id : null,
            ],
            // Pelaku Usaha dari Jawa Barat
            [
                'id' => Str::uuid(),
                'user_id' => $user5_id,
                'nama_perusahaan' => 'PT Pangan Sejahtera Bandung',
                'alamat_perusahaan' => 'Jl. Asia Afrika No. 123, Bandung',
                'jabatan_perusahaan' => 'General Manager',
                'nib' => '9988776655',
                'is_active' => true,
                'is_umkm' => false,
                'created_by' => 'seeder',
                'updated_by' => 'seeder',
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
                'provinsi_id' => $provinsi_jabar ? $provinsi_jabar->id : null,
                'kota_id' => $kota_bandung ? $kota_bandung->id : null,
            ],
            [
                'id' => Str::uuid(),
                'user_id' => $user6_id,
                'nama_perusahaan' => 'UD Bogor Raya Farm',
                'alamat_perusahaan' => 'Jl. Pajajaran No. 67, Bogor',
                'jabatan_perusahaan' => 'Owner',
                'nib' => '6677889900',
                'is_active' => true,
                'is_umkm' => true,
                'created_by' => 'seeder',
                'updated_by' => 'seeder',
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
                'provinsi_id' => $provinsi_jabar ? $provinsi_jabar->id : null,
                'kota_id' => $kota_bogor ? $kota_bogor->id : null,
            ],
        ];

        DB::table('business')->insert($businesses);
    }
}
