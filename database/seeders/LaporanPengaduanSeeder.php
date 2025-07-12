<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\LaporanPengaduan;
use App\Models\Workflow;
use App\Models\User;
use App\Models\MasterProvinsi;
use App\Models\MasterKota;

class LaporanPengaduanSeeder extends Seeder
{
    public function run()
    {
        // Ambil ID user, provinsi, kota yang sudah ada
        $user = User::first();
        $provinsi = MasterProvinsi::first();
        $kota = MasterKota::where('provinsi_id', $provinsi ? $provinsi->id : null)->first();

        if (!$user || !$provinsi || !$kota) {
            $this->command->warn('Seeder gagal: User, Provinsi, atau Kota tidak ditemukan.');
            return;
        }

        $laporanData = [
            [
                'nama_pelapor' => 'Budi Santoso',
                'nik_pelapor' => '1234567890123456',
                'nomor_telepon_pelapor' => '081234567890',
                'email_pelapor' => 'budi@example.com',
                'lokasi_kejadian' => 'Supermarket X, Jl. Merdeka No. 1',
                'isi_laporan' => 'Ditemukan cabe merah yang terindikasi jamur dijual di Supermarket X.',
                'tindak_lanjut_pertama' => 'Sudah dilaporkan ke pengelola supermarket.',
            ],
            [
                'nama_pelapor' => 'Siti Aminah',
                'nik_pelapor' => null,
                'nomor_telepon_pelapor' => null,
                'email_pelapor' => 'siti@example.com',
                'lokasi_kejadian' => 'Pasar Induk, Blok A',
                'isi_laporan' => 'Kemasan makanan impor ditemukan hanya menggunakan bahasa asing tanpa bahasa Indonesia.',
                'tindak_lanjut_pertama' => 'Petugas pasar sudah diberi tahu.',
            ],
            [
                'nama_pelapor' => 'Andi Wijaya',
                'nik_pelapor' => '9876543210987654',
                'nomor_telepon_pelapor' => '082112223333',
                'email_pelapor' => null,
                'lokasi_kejadian' => 'Toko Sembako Bu Sari',
                'isi_laporan' => 'Ditemukan produk susu kadaluarsa masih dipajang di rak penjualan.',
                'tindak_lanjut_pertama' => 'Penjual sudah diminta menarik produk dari rak.',
            ],
        ];

        foreach ($laporanData as $data) {
            $workflow = Workflow::create([
                'id' => Str::uuid(),
                'user_id_initiator' => $user->id,
                'type' => 'pengaduan',
                'status' => 'open',
                'title' => 'Workflow untuk laporan: ' . $data['nama_pelapor'],
                'current_assignee_id' => $user->id,
                'parent_id' => null,
                'category' => 'pengaduan',
                'due_date' => now()->addDays(7),
                'is_active' => true,
                'created_by' => 'seeder',
                'updated_by' => null,
            ]);

            LaporanPengaduan::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'nama_pelapor' => $data['nama_pelapor'],
                'nik_pelapor' => $data['nik_pelapor'],
                'nomor_telepon_pelapor' => $data['nomor_telepon_pelapor'],
                'email_pelapor' => $data['email_pelapor'],
                'lokasi_kejadian' => $data['lokasi_kejadian'],
                'provinsi_id' => $provinsi->id,
                'kota_id' => $kota->id,
                'isi_laporan' => $data['isi_laporan'],
                'tindak_lanjut_pertama' => $data['tindak_lanjut_pertama'],
                'workflow_id' => $workflow->id,
                'is_active' => true,
                'created_by' => 'seeder',
                'updated_by' => null,
            ]);
        }
    }
}
