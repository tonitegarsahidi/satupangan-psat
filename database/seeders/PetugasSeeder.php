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

        // Get all users with "kantor" in their name or email
        $users = DB::table('users')
            ->where('name', 'like', 'Kantor%')
            ->orWhere('email', 'like', 'kantor%@satupangan.id')
            ->get();

        // Get a list of provinsi IDs for penempatan
        $provinsis = DB::table('master_provinsis')->pluck('id', 'nama_provinsi')->toArray();

        $petugas = [];
        foreach ($users as $user) {
            $isKantorPusat = (strtolower($user->name) === 'kantor pusat');
            $penempatan = null;

            if (!$isKantorPusat) {
                // Try to match provinsi from user name, e.g. "Kantor Jatim" => "Jatim"
                $provinsiName = trim(str_ireplace('Kantor', '', $user->name));
                // Find provinsi by partial match
                $found = null;
                foreach ($provinsis as $nama => $id) {
                    if (stripos($nama, $provinsiName) !== false) {
                        $found = $id;
                        break;
                    }
                }
                $penempatan = $found ?: null;
            }

            $petugas[] = [
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'unit_kerja' => $user->name,
                'jabatan' => 'Petugas',
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
