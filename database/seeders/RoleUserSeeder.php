<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Assign roles to users
         $roleIdUser = DB::table('role_master')->where('role_code', 'ROLE_USER')->value('id');
         $roleIdPengusaha = DB::table('role_master')->where('role_code', 'ROLE_USER_BUSINESS')->value('id');
         $roleIdAdmin = DB::table('role_master')->where('role_code', 'ROLE_ADMIN')->value('id');
         $roleIdOperator = DB::table('role_master')->where('role_code', 'ROLE_OPERATOR')->value('id');
         $roleIdSupervisor = DB::table('role_master')->where('role_code', 'ROLE_SUPERVISOR')->value('id');// Assign roles to users

         //find the id of the users
         $userIdSuperAdmin  = DB::table('users')->where('email', 'superadmin@panganaman.my.id')->value('id');
         $userIdUser        = DB::table('users')->where('email', 'user@panganaman.my.id')->value('id');
         $userIdUser2        = DB::table('users')->where('email', 'user2@panganaman.my.id')->value('id');
         $userIdPengusaha    = DB::table('users')->where('email', 'pengusaha@panganaman.my.id')->value('id');
         $userIdPengusaha2   = DB::table('users')->where('email', 'pengusaha2@panganaman.my.id')->value('id');
         $userIdAdmin       = DB::table('users')->where('email', 'admin@panganaman.my.id')->value('id');
         $userIdOperator    = DB::table('users')->where('email', 'operator@panganaman.my.id')->value('id');
         $userIdSupervisor  = DB::table('users')->where('email', 'supervisor@panganaman.my.id')->value('id');

         $userIdKantorPusat = DB::table('users')->where('email', 'kantorpusat@panganaman.my.id')->value('id');
         $userIdKantorJatim = DB::table('users')->where('email', 'kantorjatim@panganaman.my.id')->value('id');
         $userIdKantorJateng = DB::table('users')->where('email', 'kantorjateng@panganaman.my.id')->value('id');
         $userIdKantorJogja = DB::table('users')->where('email', 'kantorjogja@panganaman.my.id')->value('id');
         $userIdKantorJabar = DB::table('users')->where('email', 'kantorjabar@panganaman.my.id')->value('id');
         $userIdKantorBanten = DB::table('users')->where('email', 'kantorbanten@panganaman.my.id')->value('id');
         $userIdKantorJakarta = DB::table('users')->where('email', 'kantorjakarta@panganaman.my.id')->value('id');
         $userIdKantorSumatera = DB::table('users')->where('email', 'kantorsumatera@panganaman.my.id')->value('id');
         $userIdKantorKalimantan = DB::table('users')->where('email', 'kantorkalimantan@panganaman.my.id')->value('id');
         $userIdKantorSulawesi = DB::table('users')->where('email', 'kantorsulawesi@panganaman.my.id')->value('id');
         $userIdKantorBali = DB::table('users')->where('email', 'kantorbali@panganaman.my.id')->value('id');
         $userIdKantorNTT = DB::table('users')->where('email', 'kantorntt@panganaman.my.id')->value('id');
         $userIdKantorNTB = DB::table('users')->where('email', 'kantorntb@panganaman.my.id')->value('id');


         $userRoles = [
             ['id' => Str::uuid(), 'user_id' => $userIdSuperAdmin, 'role_id' => $roleIdUser],        // superadmin has ROLE_USER
             ['id' => Str::uuid(), 'user_id' => $userIdSuperAdmin, 'role_id' => $roleIdAdmin],       // superadmin has ROLE_ADMIN
             ['id' => Str::uuid(), 'user_id' => $userIdSuperAdmin, 'role_id' => $roleIdOperator],    // superadmin has ROLE_OPERATOR
             ['id' => Str::uuid(), 'user_id' => $userIdSuperAdmin, 'role_id' => $roleIdSupervisor],  // superadmin has ROLE_SUPERVISOR

             ['id' => Str::uuid(), 'user_id' => $userIdAdmin, 'role_id' => $roleIdUser],        // admin has ROLE_USER
             ['id' => Str::uuid(), 'user_id' => $userIdAdmin, 'role_id' => $roleIdAdmin],       // admin has ROLE_ADMIN

             ['id' => Str::uuid(), 'user_id' => $userIdSupervisor, 'role_id' => $roleIdUser],        // supervisor has ROLE_USER
             ['id' => Str::uuid(), 'user_id' => $userIdSupervisor, 'role_id' => $roleIdSupervisor],  // supervisor has ROLE_SUPERVISOR

             ['id' => Str::uuid(), 'user_id' => $userIdOperator, 'role_id' => $roleIdUser],        // operator has ROLE_USER
             ['id' => Str::uuid(), 'user_id' => $userIdOperator, 'role_id' => $roleIdOperator],    // operator has ROLE_OPERATOR

             ['id' => Str::uuid(), 'user_id' => $userIdUser, 'role_id' => $roleIdUser],        // user has ROLE_USER
             ['id' => Str::uuid(), 'user_id' => $userIdUser2, 'role_id' => $roleIdUser],        // user has ROLE_USER

             ['id' => Str::uuid(), 'user_id' => $userIdPengusaha, 'role_id' => $roleIdUser],        // pengusaha has ROLE_USER
             ['id' => Str::uuid(), 'user_id' => $userIdPengusaha2, 'role_id' => $roleIdUser],        // pengusaha2 has ROLE_USER
             ['id' => Str::uuid(), 'user_id' => $userIdPengusaha, 'role_id' => $roleIdPengusaha],        // pengusaha has ROLE_USER_BUSINESS
             ['id' => Str::uuid(), 'user_id' => $userIdPengusaha2, 'role_id' => $roleIdPengusaha],        // pengusaha2 has ROLE_USER_BUSINESS

             ['id' => Str::uuid(), 'user_id' => $userIdKantorPusat, 'role_id' => $roleIdSupervisor], // Kantor Pusat has ROLE_SUPERVISOR
             ['id' => Str::uuid(), 'user_id' => $userIdKantorPusat, 'role_id' => $roleIdUser],       // Kantor Pusat has ROLE_USER

             ['id' => Str::uuid(), 'user_id' => $userIdKantorJatim, 'role_id' => $roleIdOperator],   // Kantor Jatim has ROLE_OPERATOR
             ['id' => Str::uuid(), 'user_id' => $userIdKantorJatim, 'role_id' => $roleIdUser],       // Kantor Jatim has ROLE_USER

             ['id' => Str::uuid(), 'user_id' => $userIdKantorJateng, 'role_id' => $roleIdOperator],  // Kantor Jateng has ROLE_OPERATOR
             ['id' => Str::uuid(), 'user_id' => $userIdKantorJateng, 'role_id' => $roleIdUser],      // Kantor Jateng has ROLE_USER

             ['id' => Str::uuid(), 'user_id' => $userIdKantorJogja, 'role_id' => $roleIdOperator],   // Kantor Jogja has ROLE_OPERATOR
             ['id' => Str::uuid(), 'user_id' => $userIdKantorJogja, 'role_id' => $roleIdUser],       // Kantor Jogja has ROLE_USER

             ['id' => Str::uuid(), 'user_id' => $userIdKantorJabar, 'role_id' => $roleIdOperator],   // Kantor Jabar has ROLE_OPERATOR
             ['id' => Str::uuid(), 'user_id' => $userIdKantorJabar, 'role_id' => $roleIdUser],       // Kantor Jabar has ROLE_USER

             ['id' => Str::uuid(), 'user_id' => $userIdKantorBanten, 'role_id' => $roleIdOperator],  // Kantor Banten has ROLE_OPERATOR
             ['id' => Str::uuid(), 'user_id' => $userIdKantorBanten, 'role_id' => $roleIdUser],      // Kantor Banten has ROLE_USER

             ['id' => Str::uuid(), 'user_id' => $userIdKantorJakarta, 'role_id' => $roleIdOperator], // Kantor Jakarta has ROLE_OPERATOR
             ['id' => Str::uuid(), 'user_id' => $userIdKantorJakarta, 'role_id' => $roleIdUser],     // Kantor Jakarta has ROLE_USER

             ['id' => Str::uuid(), 'user_id' => $userIdKantorSumatera, 'role_id' => $roleIdOperator], // Kantor Sumatera has ROLE_OPERATOR
             ['id' => Str::uuid(), 'user_id' => $userIdKantorSumatera, 'role_id' => $roleIdUser],    // Kantor Sumatera has ROLE_USER

             ['id' => Str::uuid(), 'user_id' => $userIdKantorKalimantan, 'role_id' => $roleIdOperator], // Kantor Kalimantan has ROLE_OPERATOR
             ['id' => Str::uuid(), 'user_id' => $userIdKantorKalimantan, 'role_id' => $roleIdUser],    // Kantor Kalimantan has ROLE_USER

             ['id' => Str::uuid(), 'user_id' => $userIdKantorSulawesi, 'role_id' => $roleIdOperator], // Kantor Sulawesi has ROLE_OPERATOR
             ['id' => Str::uuid(), 'user_id' => $userIdKantorSulawesi, 'role_id' => $roleIdUser],    // Kantor Sulawesi has ROLE_USER

             ['id' => Str::uuid(), 'user_id' => $userIdKantorBali, 'role_id' => $roleIdOperator],    // Kantor Bali has ROLE_OPERATOR
             ['id' => Str::uuid(), 'user_id' => $userIdKantorBali, 'role_id' => $roleIdUser],        // Kantor Bali has ROLE_USER

             ['id' => Str::uuid(), 'user_id' => $userIdKantorNTT, 'role_id' => $roleIdOperator],     // Kantor NTT has ROLE_OPERATOR
             ['id' => Str::uuid(), 'user_id' => $userIdKantorNTT, 'role_id' => $roleIdUser],         // Kantor NTT has ROLE_USER

             ['id' => Str::uuid(), 'user_id' => $userIdKantorNTB, 'role_id' => $roleIdOperator],     // Kantor NTB has ROLE_OPERATOR
             ['id' => Str::uuid(), 'user_id' => $userIdKantorNTB, 'role_id' => $roleIdUser],         // Kantor NTB has ROLE_USER

         ];

         DB::table('role_user')->insert($userRoles);
    }
}
