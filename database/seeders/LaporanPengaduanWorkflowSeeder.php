<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\LaporanPengaduan;
use App\Models\User;

class LaporanPengaduanWorkflowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all laporan pengaduan
        $laporans = LaporanPengaduan::all();

        // Get admin user for workflow actions
        $adminUser = User::whereHas('roles', function($query) {
            $query->where('role_code', 'ROLE_ADMIN');
        })->first();

        if (!$adminUser) {
            // If no admin user found, create a default one
            $adminUser = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'is_active' => true,
                'created_by' => 'seeder',
            ]);
        }

        // Get regular user for report creation
        $regularUser = User::whereHas('roles', function($query) {
            $query->where('role_code', 'ROLE_USER');
        })->first();

        if (!$regularUser) {
            // If no regular user found, create a default one
            $regularUser = User::create([
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'is_active' => true,
                'created_by' => 'seeder',
            ]);
        }

        $workflowData = [];

        foreach ($laporans as $laporan) {
            // Determine the end status randomly: SELESAI, DIBATALKAN, or DITUTUP
            $endStatus = $this->getRandomEndStatus();

            // Create workflow entries based on the end status
            if ($endStatus === 'SELESAI') {
                $workflowData[] = [
                    'id' => Str::uuid(),
                    'user_id' => $regularUser->id,
                    'laporan_pengaduan_id' => $laporan->id,
                    'status' => 'Dibuat',
                    'message' => 'Laporan pengaduan berhasil dibuat oleh pengguna',
                    'created_at' => now()->subDays(5),
                    'updated_at' => now()->subDays(5),
                ];

                $workflowData[] = [
                    'id' => Str::uuid(),
                    'user_id' => $adminUser->id,
                    'laporan_pengaduan_id' => $laporan->id,
                    'status' => 'Diproses',
                    'message' => 'Laporan sedang dalam proses penanganan oleh petugas',
                    'created_at' => now()->subDays(4),
                    'updated_at' => now()->subDays(4),
                ];

                $workflowData[] = [
                    'id' => Str::uuid(),
                    'user_id' => $adminUser->id,
                    'laporan_pengaduan_id' => $laporan->id,
                    'status' => 'Dalam Tinjauan',
                    'message' => 'Tim ahli sedang melakukan analisis dan tinjauan laporan',
                    'created_at' => now()->subDays(3),
                    'updated_at' => now()->subDays(3),
                ];

                $workflowData[] = [
                    'id' => Str::uuid(),
                    'user_id' => $adminUser->id,
                    'laporan_pengaduan_id' => $laporan->id,
                    'status' => 'SELESAI',
                    'message' => 'Laporan telah selesai ditangani dan tindak lanjut telah diberikan kepada pelapor',
                    'created_at' => now()->subDays(1),
                    'updated_at' => now()->subDays(1),
                ];

            } elseif ($endStatus === 'DIBATALKAN') {
                $workflowData[] = [
                    'id' => Str::uuid(),
                    'user_id' => $regularUser->id,
                    'laporan_pengaduan_id' => $laporan->id,
                    'status' => 'Dibuat',
                    'message' => 'Laporan pengaduan berhasil dibuat oleh pengguna',
                    'created_at' => now()->subDays(5),
                    'updated_at' => now()->subDays(5),
                ];

                $workflowData[] = [
                    'id' => Str::uuid(),
                    'user_id' => $adminUser->id,
                    'laporan_pengaduan_id' => $laporan->id,
                    'status' => 'Diproses',
                    'message' => 'Laporan sedang dalam proses penanganan oleh petugas',
                    'created_at' => now()->subDays(4),
                    'updated_at' => now()->subDays(4),
                ];

                $workflowData[] = [
                    'id' => Str::uuid(),
                    'user_id' => $adminUser->id,
                    'laporan_pengaduan_id' => $laporan->id,
                    'status' => 'Dibatalkan',
                    'message' => 'Laporan dibatalkan karena informasi yang diberikan tidak lengkap atau tidak valid',
                    'created_at' => now()->subDays(2),
                    'updated_at' => now()->subDays(2),
                ];

            } elseif ($endStatus === 'DITUTUP') {
                $workflowData[] = [
                    'id' => Str::uuid(),
                    'user_id' => $regularUser->id,
                    'laporan_pengaduan_id' => $laporan->id,
                    'status' => 'Dibuat',
                    'message' => 'Laporan pengaduan berhasil dibuat oleh pengguna',
                    'created_at' => now()->subDays(6),
                    'updated_at' => now()->subDays(6),
                ];

                $workflowData[] = [
                    'id' => Str::uuid(),
                    'user_id' => $adminUser->id,
                    'laporan_pengaduan_id' => $laporan->id,
                    'status' => 'Diproses',
                    'message' => 'Laporan sedang dalam proses penanganan oleh petugas',
                    'created_at' => now()->subDays(5),
                    'updated_at' => now()->subDays(5),
                ];

                $workflowData[] = [
                    'id' => Str::uuid(),
                    'user_id' => $adminUser->id,
                    'laporan_pengaduan_id' => $laporan->id,
                    'status' => 'Dalam Tinjauan',
                    'message' => 'Tim ahli sedang melakukan analisis dan tinjauan laporan',
                    'created_at' => now()->subDays(4),
                    'updated_at' => now()->subDays(4),
                ];

                $workflowData[] = [
                    'id' => Str::uuid(),
                    'user_id' => $adminUser->id,
                    'laporan_pengaduan_id' => $laporan->id,
                    'status' => 'Perlu Tindakan',
                    'message' => 'Ditemukan pelanggaran namun perlu tindakan lebih lanjut dari pihak terkait',
                    'created_at' => now()->subDays(3),
                    'updated_at' => now()->subDays(3),
                ];

                $workflowData[] = [
                    'id' => Str::uuid(),
                    'user_id' => $adminUser->id,
                    'laporan_pengaduan_id' => $laporan->id,
                    'status' => 'DITUTUP',
                    'message' => 'Laporan ditutup setelah tindakan yang telah diambil dan monitoring berjalan sesuai rencana',
                    'created_at' => now()->subDays(1),
                    'updated_at' => now()->subDays(1),
                ];
            }
        }

        // Insert all workflow data
        DB::table('laporan_pengaduan_workflow')->insert($workflowData);
    }

    private function getRandomEndStatus(): string
    {
        $statuses = ['SELESAI', 'DIBATALKAN', 'DITUTUP'];
        return $statuses[array_rand($statuses)];
    }
}
