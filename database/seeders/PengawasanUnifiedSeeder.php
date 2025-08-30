<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengawasanUnifiedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to allow seeding in specific order
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Truncate tables to ensure clean state
        DB::table('pengawasan_rekap_pengawasan')->truncate();
        DB::table('pengawasan_rekap')->truncate();
        DB::table('pengawasan')->truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Run seeders in correct order
        $this->command->info('Running PengawasanSeeder...');
        $this->call(PengawasanSeeder::class);

        $this->command->info('Running PengawasanRekapSeeder...');
        $this->call(PengawasanRekapSeeder::class);

        $this->command->info('Running PengawasanRekapPengawasanSeeder...');
        $this->call(PengawasanRekapPengawasanSeeder::class);

        $this->command->info('All pengawasan seeders completed successfully!');
    }
}
