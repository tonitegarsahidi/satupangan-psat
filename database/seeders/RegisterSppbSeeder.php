<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RegisterSppb;
use App\Models\Business;
use App\Models\MasterProvinsi;
use App\Models\MasterKota;
use Illuminate\Support\Str;

class RegisterSppbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure there's at least one business, province, and city for foreign keys
        $business = Business::first();
        if (!$business) {
            $business = Business::create([
                'id' => Str::uuid(),
                'nama_usaha' => 'Dummy Business',
                'alamat_usaha' => 'Jl. Dummy No. 123',
                'email_usaha' => 'dummy@example.com',
                'nomor_telepon_usaha' => '081234567890',
                'nib_usaha' => '123456789012345',
                'is_active' => true,
            ]);
        }

        $provinsi = MasterProvinsi::first();
        if (!$provinsi) {
            $provinsi = MasterProvinsi::create([
                'id' => Str::uuid(),
                'kode_provinsi' => 'DP',
                'nama_provinsi' => 'Dummy Provinsi',
                'is_active' => true,
            ]);
        }

        $kota = MasterKota::first();
        if (!$kota) {
            $kota = MasterKota::create([
                'id' => Str::uuid(),
                'master_provinsi_id' => $provinsi->id,
                'kode_kota' => 'DK',
                'nama_kota' => 'Dummy Kota',
                'is_active' => true,
            ]);
        }

        RegisterSppb::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'DRAFT',
            'is_enabled' => true,
            'nomor_registrasi' => 'REG-SPPB-001',
            'tanggal_terbit' => '2025-01-01',
            'tanggal_terakhir' => '2026-01-01',
            'is_unitusaha' => true,
            'nama_unitusaha' => 'Unit Usaha A',
            'alamat_unitusaha' => 'Jl. Unit A No. 1',
            'provinsi_unitusaha' => $provinsi->id,
            'kota_unitusaha' => $kota->id,
            'nib_unitusaha' => 'NIB-A-001',
        ]);

        RegisterSppb::create([
            'id' => Str::uuid(),
            'business_id' => $business->id,
            'status' => 'SUBMITTED',
            'is_enabled' => true,
            'nomor_registrasi' => 'REG-SPPB-002',
            'tanggal_terbit' => '2025-02-01',
            'tanggal_terakhir' => '2026-02-01',
            'is_unitusaha' => false,
            'nama_unitusaha' => null,
            'alamat_unitusaha' => null,
            'provinsi_unitusaha' => null,
            'kota_unitusaha' => null,
            'nib_unitusaha' => null,
        ]);
    }
}
