<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\{
    MasterJenisPanganSegar,
    MasterCemaranLogamBerat,
    MasterCemaranMikroba,
    MasterCemaranMikrotoksin,
    MasterCemaranPestisida
};

class BatasCemaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all jenis pangan segar
        $jenisPangans = MasterJenisPanganSegar::all();

        // Get all cemaran logam berat
        $logamBerats = MasterCemaranLogamBerat::all();

        // Get all cemaran mikroba
        $mikrobas = MasterCemaranMikroba::all();

        // Get all cemaran mikrotoksin
        $mikrotoxins = MasterCemaranMikrotoksin::all();

        // Get all cemaran pestisida
        $pestisidas = MasterCemaranPestisida::all();

        // Seed Batas Cemaran Logam Berat
        foreach ($jenisPangans as $jenisPangan) {
            foreach ($logamBerats as $logamBerat) {
                \App\Models\BatasCemaranLogamBerat::create([
                    'id' => Str::uuid(),
                    'jenis_psat' => $jenisPangan->id,
                    'cemaran_logam_berat' => $logamBerat->id,
                    'value_min' => 0,
                    'value_max' => match($logamBerat->kode_cemaran_logam_berat) {
                        'CLB001' => 0.3, // Timbal (Pb)
                        'CLB002' => 0.2, // Kadmium (Cd)
                        default => 0.1
                    },
                    'satuan' => 'mg/kg',
                    'metode' => 'SNI 01-2893-1992',
                    'keterangan' => 'Batas maksimum logam berat untuk ' . $jenisPangan->nama_jenis_pangan_segar,
                    'is_active' => true,
                    'created_by' => 'seeder',
                    'updated_by' => 'seeder',
                ]);
            }
        }

        // Seed Batas Cemaran Mikroba
        foreach ($jenisPangans as $jenisPangan) {
            foreach ($mikrobas as $mikroba) {
                \App\Models\BatasCemaranMikroba::create([
                    'id' => Str::uuid(),
                    'jenis_psat' => $jenisPangan->id,
                    'cemaran_mikroba' => $mikroba->id,
                    'value_min' => 0,
                    'value_max' => match($mikroba->kode_cemaran_mikroba) {
                        'CMB001' => 10,   // Escherichia coli
                        'CMB002' => 0,    // Salmonella sp. (tidak boleh ada)
                        default => 100
                    },
                    'satuan' => 'CFU/g',
                    'metode' => 'SNI 01-2892-1992',
                    'keterangan' => 'Batas maksimum mikroba untuk ' . $jenisPangan->nama_jenis_pangan_segar,
                    'is_active' => true,
                    'created_by' => 'seeder',
                    'updated_by' => 'seeder',
                ]);
            }
        }

        // Seed Batas Cemaran Mikrotoksin
        foreach ($jenisPangans as $jenisPangan) {
            foreach ($mikrotoxins as $mikrotoksin) {
                \App\Models\BatasCemaranMikrotoksin::create([
                    'id' => Str::uuid(),
                    'jenis_psat' => $jenisPangan->id,
                    'cemaran_mikrotoksin' => $mikrotoksin->id,
                    'value_min' => 0,
                    'value_max' => match($mikrotoksin->kode_cemaran_mikrotoksin) {
                        'CMT001' => 0.025, // Aflatoksin
                        'CMT002' => 0.05,  // Okratoksin A
                        default => 0.01
                    },
                    'satuan' => 'mg/kg',
                    'metode' => 'SNI 01-7208-2016',
                    'keterangan' => 'Batas maksimum mikrotoksin untuk ' . $jenisPangan->nama_jenis_pangan_segar,
                    'is_active' => true,
                    'created_by' => 'seeder',
                    'updated_by' => 'seeder',
                ]);
            }
        }

        // Seed Batas Cemaran Pestisida
        foreach ($jenisPangans as $jenisPangan) {
            foreach ($pestisidas as $pestisida) {
                \App\Models\BatasCemaranPestisida::create([
                    'id' => Str::uuid(),
                    'jenis_psat' => $jenisPangan->id,
                    'cemaran_pestisida' => $pestisida->id,
                    'value_min' => 0,
                    'value_max' => match($pestisida->kode_cemaran_pestisida) {
                        'PST001' => 0.01, // Karbofuran
                        'PST002' => 0.05, // Klorpirifos
                        default => 0.01
                    },
                    'satuan' => 'mg/kg',
                    'metode' => 'SNI 01-3982-2006',
                    'keterangan' => 'Batas maksimum residu pestisida untuk ' . $jenisPangan->nama_jenis_pangan_segar,
                    'is_active' => true,
                    'created_by' => 'seeder',
                    'updated_by' => 'seeder',
                ]);
            }
        }
    }
}
