<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert users
        $users = [
            [
                'id' => Str::uuid(),
                'name' => 'Super Admin',
                'email' => 'superadmin@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Pak Bon Admin',
                'email' => 'admin@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Si Tegar Supervisor',
                'email' => 'supervisor@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Sam Didi Operator',
                'email' => 'operator@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Sam Toni User',
                'email' => 'user@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Sam Toni User',
                'email' => 'user2@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Pak Melon Importir',
                'email' => 'pengusaha@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Pas Sambo Petani',
                'email' => 'pengusaha2@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Pusat',
                'email' => 'kantorpusat@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Jateng',
                'email' => 'kantorjateng@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Jabar',
                'email' => 'kantorjabar@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'id' => Str::uuid(),
                'name' => 'Kantor Aceh',
                'email' => 'kantoraceh@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Bali',
                'email' => 'kantorbali@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Babel',
                'email' => 'kantorbabel@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Bengkulu',
                'email' => 'kantorbengkulu@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor DIY',
                'email' => 'kantordiY@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Gorontalo',
                'email' => 'kantorgorontalo@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Jambi',
                'email' => 'kantorjambi@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Jatim',
                'email' => 'kantorjatim@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Kalbar',
                'email' => 'kantorkalbar@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Kalsel',
                'email' => 'kantorkalsel@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Kalteng',
                'email' => 'kantorkalteng@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Kaltim',
                'email' => 'kantorkaltim@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Kaltara',
                'email' => 'kantorkaltara@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Kepri',
                'email' => 'kantorkepri@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Lampung',
                'email' => 'kantorlampung@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Maluku',
                'email' => 'kantormaluku@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Malut',
                'email' => 'kantormalut@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor NTB',
                'email' => 'kantorntb@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor NTT',
                'email' => 'kantorntt@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Papua',
                'email' => 'kantorpapua@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Pabar',
                'email' => 'kantorpabar@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Riau',
                'email' => 'kantorriau@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Sulbar',
                'email' => 'kantorsulbar@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Sulsel',
                'email' => 'kantorsulsel@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Sulteng',
                'email' => 'kantorsulteng@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Sultra',
                'email' => 'kantorsultra@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Sulut',
                'email' => 'kantorsulut@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Sumbar',
                'email' => 'kantorsumbar@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Sumsel',
                'email' => 'kantorsumsel@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Sumut',
                'email' => 'kantorsumut@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Pimpinan',
                'email' => 'pimpinan@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ];

        // Add missing kantor users that are referenced in RoleUserSeeder
        $missingKantorUsers = [
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Jogja',
                'email' => 'kantorjogja@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Banten',
                'email' => 'kantorbanten@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Jakarta',
                'email' => 'kantorjakarta@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Sumatera',
                'email' => 'kantorsumatera@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Kalimantan',
                'email' => 'kantorkalimantan@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor Sulawesi',
                'email' => 'kantorsulawesi@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor NTT',
                'email' => 'kantorntt@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kantor NTB',
                'email' => 'kantorntb@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        $allUsers = array_merge($users, $missingKantorUsers);

        // Insert users while avoiding duplicates
        foreach ($allUsers as $user) {
            $existing = DB::table('users')->where('email', $user['email'])->first();
            if (!$existing) {
                DB::table('users')->insert($user);
            }
        }

        // Create petugas* and pimpinan* users for each kantor* user
        $kantorUsers = array_filter($allUsers, function($user) {
            return strpos($user['email'], 'kantor') === 0 && strpos($user['email'], '@panganaman.my.id') !== false;
        });

        // Get all existing emails to avoid duplicate queries
        $existingEmails = DB::table('users')->pluck('email')->toArray();

        $newUsers = [];

        foreach ($kantorUsers as $kantorUser) {
            // Create petugas* user
            $petugasEmail = str_replace('kantor', 'petugas', $kantorUser['email']);
            $petugasName = str_replace('Kantor', 'Petugas', $kantorUser['name']);

            if (!in_array($petugasEmail, $existingEmails)) {
                $newUsers[] = [
                    'id' => Str::uuid(),
                    'name' => $petugasName,
                    'email' => $petugasEmail,
                    'password' => Hash::make('password123'),
                    'is_active' => true,
                    'email_verified_at' => Carbon::now(),
                    'phone_number' => '0811111111111',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                $existingEmails[] = $petugasEmail;
            }

            // Create pimpinan* user
            $pimpinanEmail = str_replace('kantor', 'pimpinan', $kantorUser['email']);
            $pimpinanName = str_replace('Kantor', 'Pimpinan', $kantorUser['name']);

            if (!in_array($pimpinanEmail, $existingEmails)) {
                $newUsers[] = [
                    'id' => Str::uuid(),
                    'name' => $pimpinanName,
                    'email' => $pimpinanEmail,
                    'password' => Hash::make('password123'),
                    'is_active' => true,
                    'email_verified_at' => Carbon::now(),
                    'phone_number' => '0811111111111',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                $existingEmails[] = $pimpinanEmail;
            }
        }

        // Special handling for kantorpusat - create petugaspusat and pimpinanpusat
        if (!in_array('petugaspusat@panganaman.my.id', $existingEmails)) {
            $newUsers[] = [
                'id' => Str::uuid(),
                'name' => 'Petugas Pusat',
                'email' => 'petugaspusat@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $existingEmails[] = 'petugaspusat@panganaman.my.id';
        }

        if (!in_array('pimpinanpusat@panganaman.my.id', $existingEmails)) {
            $newUsers[] = [
                'id' => Str::uuid(),
                'name' => 'Pimpinan Pusat',
                'email' => 'pimpinanpusat@panganaman.my.id',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'phone_number' => '0811111111111',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $existingEmails[] = 'pimpinanpusat@panganaman.my.id';
        }

        // Insert all new users in a single query
        if (!empty($newUsers)) {
            DB::table('users')->insert($newUsers);
        }
    }
}
