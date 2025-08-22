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
         $roleIdSupervisor = DB::table('role_master')->where('role_code', 'ROLE_SUPERVISOR')->value('id');
         $roleIdLeader = DB::table('role_master')->where('role_code', 'ROLE_LEADER')->value('id');

         //find the id of the users
         $userIdSuperAdmin  = DB::table('users')->where('email', 'superadmin@panganaman.my.id')->value('id');
         $userIdUser        = DB::table('users')->where('email', 'user@panganaman.my.id')->value('id');
         $userIdUser2        = DB::table('users')->where('email', 'user2@panganaman.my.id')->value('id');
         $userIdPengusaha    = DB::table('users')->where('email', 'pengusaha@panganaman.my.id')->value('id');
         $userIdPengusaha2   = DB::table('users')->where('email', 'pengusaha2@panganaman.my.id')->value('id');
         $userIdAdmin       = DB::table('users')->where('email', 'admin@panganaman.my.id')->value('id');
         $userIdOperator    = DB::table('users')->where('email', 'operator@panganaman.my.id')->value('id');
         $userIdSupervisor  = DB::table('users')->where('email', 'supervisor@panganaman.my.id')->value('id');
         $userIdLeader = DB::table('users')->where('email', 'pimpinan@panganaman.my.id')->value('id');

         // Get all kantor user IDs that exist in the database
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

         // Get IDs for all new kantor users
         $userIdKantorAceh = DB::table('users')->where('email', 'kantoraceh@panganaman.my.id')->value('id');
         $userIdKantorBabel = DB::table('users')->where('email', 'kantorbabel@panganaman.my.id')->value('id');
         $userIdKantorBengkulu = DB::table('users')->where('email', 'kantorbengkulu@panganaman.my.id')->value('id');
         $userIdKantorDIY = DB::table('users')->where('email', 'kantordiY@panganaman.my.id')->value('id');
         $userIdKantorGorontalo = DB::table('users')->where('email', 'kantorgorontalo@panganaman.my.id')->value('id');
         $userIdKantorJambi = DB::table('users')->where('email', 'kantorjambi@panganaman.my.id')->value('id');
         $userIdKantorKalbar = DB::table('users')->where('email', 'kantorkalbar@panganaman.my.id')->value('id');
         $userIdKantorKalsel = DB::table('users')->where('email', 'kantorkalsel@panganaman.my.id')->value('id');
         $userIdKantorKalteng = DB::table('users')->where('email', 'kantorkalteng@panganaman.my.id')->value('id');
         $userIdKantorKaltim = DB::table('users')->where('email', 'kantorkaltim@panganaman.my.id')->value('id');
         $userIdKantorKaltara = DB::table('users')->where('email', 'kantorkaltara@panganaman.my.id')->value('id');
         $userIdKantorKepri = DB::table('users')->where('email', 'kantorkepri@panganaman.my.id')->value('id');
         $userIdKantorLampung = DB::table('users')->where('email', 'kantorlampung@panganaman.my.id')->value('id');
         $userIdKantorMaluku = DB::table('users')->where('email', 'kantormaluku@panganaman.my.id')->value('id');
         $userIdKantorMalut = DB::table('users')->where('email', 'kantormalut@panganaman.my.id')->value('id');
         $userIdKantorPapua = DB::table('users')->where('email', 'kantorpapua@panganaman.my.id')->value('id');
         $userIdKantorPabar = DB::table('users')->where('email', 'kantorpabar@panganaman.my.id')->value('id');
         $userIdKantorRiau = DB::table('users')->where('email', 'kantorriau@panganaman.my.id')->value('id');
         $userIdKantorSulbar = DB::table('users')->where('email', 'kantorsulbar@panganaman.my.id')->value('id');
         $userIdKantorSulsel = DB::table('users')->where('email', 'kantorsulsel@panganaman.my.id')->value('id');
         $userIdKantorSulteng = DB::table('users')->where('email', 'kantorsulteng@panganaman.my.id')->value('id');
         $userIdKantorSultra = DB::table('users')->where('email', 'kantorsultra@panganaman.my.id')->value('id');
         $userIdKantorSulut = DB::table('users')->where('email', 'kantorsulut@panganaman.my.id')->value('id');
         $userIdKantorSumbar = DB::table('users')->where('email', 'kantorsumbar@panganaman.my.id')->value('id');
         $userIdKantorSumsel = DB::table('users')->where('email', 'kantorsumsel@panganaman.my.id')->value('id');
         $userIdKantorSumut = DB::table('users')->where('email', 'kantorsumut@panganaman.my.id')->value('id');

         $userRoles = [];

         // Define role assignments for each user type
         $roleAssignments = [
             // Super Admin gets multiple roles
             $userIdSuperAdmin => [$roleIdUser, $roleIdAdmin, $roleIdOperator, $roleIdSupervisor],

             // Admin gets user and admin roles
             $userIdAdmin => [$roleIdUser, $roleIdAdmin],

             // Supervisor gets user and supervisor roles
             $userIdSupervisor => [$roleIdUser, $roleIdSupervisor],

             // Operator gets user and operator roles
             $userIdOperator => [$roleIdUser, $roleIdOperator],

             // Regular users get only user role
             $userIdUser => [$roleIdUser],
             $userIdUser2 => [$roleIdUser],

             // Pengusaha get user and pengusaha roles
             $userIdPengusaha => [$roleIdUser, $roleIdPengusaha],
             $userIdPengusaha2 => [$roleIdUser, $roleIdPengusaha],

             // Kantor Pusat gets supervisor and user roles
             $userIdKantorPusat => [$roleIdSupervisor, $roleIdUser],
         ];

         // Add roles for all kantor users (both existing and new)
         $allKantorUsers = array_merge(
             [$userIdKantorJatim, $userIdKantorJateng, $userIdKantorJogja, $userIdKantorJabar,
              $userIdKantorBanten, $userIdKantorJakarta, $userIdKantorSumatera, $userIdKantorKalimantan,
              $userIdKantorSulawesi, $userIdKantorBali, $userIdKantorNTT, $userIdKantorNTB],
             [$userIdKantorAceh, $userIdKantorBabel, $userIdKantorBengkulu, $userIdKantorDIY,
              $userIdKantorGorontalo, $userIdKantorJambi, $userIdKantorKalbar, $userIdKantorKalsel,
              $userIdKantorKalteng, $userIdKantorKaltim, $userIdKantorKaltara, $userIdKantorKepri,
              $userIdKantorLampung, $userIdKantorMaluku, $userIdKantorMalut, $userIdKantorPapua,
              $userIdKantorPabar, $userIdKantorRiau, $userIdKantorSulbar, $userIdKantorSulsel,
              $userIdKantorSulteng, $userIdKantorSultra, $userIdKantorSulut, $userIdKantorSumbar,
              $userIdKantorSumsel, $userIdKantorSumut]
         );

         foreach ($allKantorUsers as $userId) {
             if ($userId && !isset($roleAssignments[$userId])) {
                 $roleAssignments[$userId] = [$roleIdOperator, $roleIdUser];
             }
         }

         // Add roles for pimpinan
         if ($userIdLeader && !isset($roleAssignments[$userIdLeader])) {
             $roleAssignments[$userIdLeader] = [$roleIdUser, $roleIdLeader];
         }

         // Generate role assignments, checking for existing ones first
         foreach ($roleAssignments as $userId => $roles) {
             if ($userId) {
                 foreach ($roles as $roleId) {
                     // Check if this role-user combination already exists
                     $existing = DB::table('role_user')
                         ->where('user_id', $userId)
                         ->where('role_id', $roleId)
                         ->first();

                     if (!$existing) {
                         $userRoles[] = ['id' => Str::uuid(), 'user_id' => $userId, 'role_id' => $roleId];
                     }
                 }
             }
         }

         if (!empty($userRoles)) {
             DB::table('role_user')->insert($userRoles);
         }
    }
}
