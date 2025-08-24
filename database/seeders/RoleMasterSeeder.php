<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['role_name' => 'Pengguna', 'role_code' => 'ROLE_USER'],
            ['role_name' => 'Pelaku Usaha', 'role_code' => 'ROLE_USER_BUSINESS'],
            ['role_name' => 'Petugas Badan Pangan', 'role_code' => 'ROLE_OPERATOR'],
            ['role_name' => 'Petugas Badan Pangan', 'role_code' => 'ROLE_SUPERVISOR'],
            ['role_name' => 'Administrator', 'role_code' => 'ROLE_ADMIN'],
            ['role_name' => 'Pimpinan', 'role_code' => 'ROLE_LEADER'],
            ['role_name' => 'Kantor Badan Pangan', 'role_code' => 'ROLE_KANTOR'],
        ];

        DB::table('role_master')->insert($roles);
    }
}
