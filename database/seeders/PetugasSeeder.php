<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PetugasSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        // Get all users with "kantor" in their name or email, plus specific role users
        $users = DB::table('users')
            ->where(function($query) {
                $query->where('name', 'like', 'Kantor%')
                      ->orWhere('email', 'like', 'kantor%@panganaman.my.id');
            })
            ->orWhere('name', 'Pimpinan')
            ->orWhere('email', 'pimpinan@panganaman.my.id')
            ->get();

        // Get a list of provinsi IDs for penempatan
        $provinsis = DB::table('master_provinsis')->pluck('id', 'nama_provinsi')->toArray();

        $petugas = [];
        foreach ($users as $user) {
            $isKantorPusat = (strtolower($user->name) === 'kantor pusat' || $user->email === 'kantorpusat@panganaman.my.id');
            $isPimpinan = ($user->email === 'pimpinan@panganaman.my.id');
            $penempatan = null;

            // Only set penempatan if not kantor pusat or pimpinan
            if (!$isKantorPusat && !$isPimpinan) {
                // Try to match provinsi from user name, e.g. "Kantor Jatim" => "Jatim"
                $provinsiName = trim(str_ireplace('Kantor', '', $user->name));

                // Create mapping between abbreviated names and full province names
                $provinsiMapping = [
                    'Aceh' => 'Aceh',
                    'Bali' => 'Bali',
                    'Babel' => 'Bangka Belitung',
                    'Banten' => 'Banten',
                    'Bengkulu' => 'Bengkulu',
                    'DIY' => 'DI Yogyakarta',
                    'Jakarta' => 'DKI Jakarta',
                    'Gorontalo' => 'Gorontalo',
                    'Jambi' => 'Jambi',
                    'Jabar' => 'Jawa Barat',
                    'Jateng' => 'Jawa Tengah',
                    'Jatim' => 'Jawa Timur',
                    'Kalbar' => 'Kalimantan Barat',
                    'Kalsel' => 'Kalimantan Selatan',
                    'Kalteng' => 'Kalimantan Tengah',
                    'Kaltim' => 'Kalimantan Timur',
                    'Kaltara' => 'Kalimantan Utara',
                    'Kepri' => 'Kepulauan Riau',
                    'Lampung' => 'Lampung',
                    'Maluku' => 'Maluku',
                    'Malut' => 'Maluku Utara',
                    'NTB' => 'Nusa Tenggara Barat',
                    'NTT' => 'Nusa Tenggara Timur',
                    'Papua' => 'Papua',
                    'Pabar' => 'Papua Barat',
                    'Riau' => 'Riau',
                    'Sulbar' => 'Sulawesi Barat',
                    'Sulsel' => 'Sulawesi Selatan',
                    'Sulteng' => 'Sulawesi Tengah',
                    'Sultra' => 'Sulawesi Tenggara',
                    'Sulut' => 'Sulawesi Utara',
                    'Sumbar' => 'Sumatera Barat',
                    'Sumsel' => 'Sumatera Selatan',
                    'Sumut' => 'Sumatera Utara',
                ];

                // Find provinsi by exact match first
                if (isset($provinsiMapping[$provinsiName])) {
                    $provinsiFullName = $provinsiMapping[$provinsiName];
                    if (isset($provinsis[$provinsiFullName])) {
                        $penempatan = $provinsis[$provinsiFullName];
                    }
                }

                // If no exact match, try partial match
                if ($penempatan === null) {
                    foreach ($provinsis as $nama => $id) {
                        if (stripos($nama, $provinsiName) !== false) {
                            $penempatan = $id;
                            break;
                        }
                    }
                }
            }

            $jabatan = 'Petugas';
            if ($isPimpinan) {
                $jabatan = 'Pimpinan';
            }

            $petugas[] = [
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'unit_kerja' => $user->name,
                'jabatan' => $jabatan,
                'is_kantor_pusat' => $isKantorPusat,
                'penempatan' => $penempatan,
                'is_active' => true,
                'created_by' => 'seeder',
                'updated_by' => 'seeder',
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ];
        }

        if (!empty($petugas)) {
            DB::table('petugas')->insert($petugas);
        }
    }
}
