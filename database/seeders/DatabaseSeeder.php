<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            UserSeeder::class,
            RoleMasterSeeder::class,
            RoleUserSeeder::class,
            FakeUserSeeder::class,

            //Saas related to Subscription
            SubscriptionMasterSeeder::class,
            SubscriptionUserSeeder::class,
            SubscriptionHistorySeeder::class,
            MasterProvinsiSeeder::class,
            MasterPenangananSeeder::class,

            MasterKelompokPanganSeeder::class,
            MasterJenisPanganSegarSeeder::class,
            MasterBahanPanganSegarSeeder::class,
            MasterCemaranLogamBeratSeeder::class,
            MasterCemaranMikrobaSeeder::class,
            MasterCemaranMikrotoksinSeeder::class,
            MasterCemaranPestisidaSeeder::class,
            BatasCemaranSeeder::class,
            MasterKotaSeeder::class,
            WorkflowSeeder::class,
            WorkflowActionSeeder::class,
            WorkflowThreadSeeder::class,
            WorkflowAttachmentSeeder::class,
            LaporanPengaduanSeeder::class,

            // Business & Petugas
            BusinessSeeder::class,
            BusinessJenispsatSeeder::class,
            PetugasSeeder::class,


            RegisterSppbSeeder::class,
            RegisterIzinedarPsatplSeeder::class,
            RegisterIzinedarPsatpdSeeder::class,
            RegisterIzinedarPsatpdukSeeder::class,
            RegisterSertifikatKeamananPanganSeeder::class,
            RegisterIzinrumahPengemasanSeeder::class,

            QrBadanPanganSeeder::class,

            // Notification and Message seeders
            NotificationSeeder::class,
            MessageSeeder::class,
        ]);
    }
}
