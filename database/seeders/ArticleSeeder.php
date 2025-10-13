<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin users to use as authors
        $adminUsers = User::whereHas('roles', function($query) {
            $query->where('role_code', 'ROLE_ADMIN');
        })->get();

        if ($adminUsers->isEmpty()) {
            $this->command->warn('No admin users found. Please run UserSeeder first.');
            return;
        }

        $featuredImages = [
            'images/upload/article/apples.jpg',
            'images/upload/article/cabe rawit.jpg',
            'images/upload/article/chilli.jpg',
            'images/upload/article/jagung.jpg',
            'images/upload/article/kacang tanah.jpg',
            'images/upload/article/kebun anggur.jpg',
            'images/upload/article/kebun jeruk.jpg',
            'images/upload/article/semangka.jpg',
        ];

        $articles = [
            [
                'title' => 'Pentingnya Keamanan Pangan dalam Industri Pengolahan Makanan',
                'slug' => 'pentingnya-keamanan-pangan-dalam-industri-pengolahan-makanan',
                'content' => '<p>Keamanan pangan merupakan aspek krusial dalam industri pengolahan makanan modern. Dengan semakin meningkatnya kesadaran masyarakat terhadap kesehatan dan keamanan produk yang dikonsumsi, produsen makanan dituntut untuk menerapkan standar keamanan pangan yang ketat.</p>

<p>Industri pengolahan makanan di Indonesia menghadapi berbagai tantangan dalam menjaga keamanan pangan, mulai dari pemilihan bahan baku berkualitas hingga proses pengolahan yang higienis. Penerapan sistem manajemen keamanan pangan seperti HACCP (Hazard Analysis Critical Control Points) menjadi sangat penting untuk mencegah kontaminasi dan memastikan produk aman dikonsumsi.</p>

<p>Selain itu, pelatihan berkala bagi karyawan tentang praktik keamanan pangan dan higiene sanitasi juga merupakan investasi jangka panjang yang akan meningkatkan kredibilitas perusahaan di mata konsumen.</p>',
                'excerpt' => 'Keamanan pangan merupakan aspek krusial dalam industri pengolahan makanan modern. Dengan semakin meningkatnya kesadaran masyarakat terhadap kesehatan...',
                'category' => 'pembinaan',
                'status' => 'published',
                'is_featured' => true,
                'featured_image' => $featuredImages[0],
                'published_at' => Carbon::now()->subDays(7),
                'view_count' => rand(50, 200),
            ],
            [
                'title' => 'Teknologi Pengawasan Pangan Berbasis Digital untuk UMKM',
                'slug' => 'teknologi-pengawasan-pangan-berbasis-digital-untuk-umkm',
                'content' => '<p>Penggunaan teknologi digital dalam pengawasan pangan semakin penting, terutama bagi pelaku Usaha Mikro, Kecil, dan Menengah (UMKM). Sistem pengawasan berbasis digital dapat membantu UMKM dalam memantau kualitas produk secara real-time dan efisien.</p>

<p>Aplikasi pengawasan pangan digital memungkinkan pelaku usaha untuk mencatat dan melacak setiap tahapan produksi, mulai dari penerimaan bahan baku hingga distribusi produk. Hal ini tidak hanya meningkatkan efisiensi operasional tetapi juga memudahkan dalam memenuhi standar sertifikasi keamanan pangan.</p>

<p>Dengan adopsi teknologi ini, UMKM dapat bersaing lebih baik di pasar modern dan membangun kepercayaan konsumen melalui transparansi proses produksi.</p>',
                'excerpt' => 'Penggunaan teknologi digital dalam pengawasan pangan semakin penting, terutama bagi pelaku Usaha Mikro, Kecil, dan Menengah (UMKM)...',
                'category' => 'pembinaan',
                'status' => 'published',
                'is_featured' => false,
                'featured_image' => $featuredImages[1],
                'published_at' => Carbon::now()->subDays(5),
                'view_count' => rand(30, 150),
            ],
            [
                'title' => 'Berita Terbaru: Regulasi Keamanan Pangan Diperketat',
                'slug' => 'berita-terbaru-regulasi-keamanan-pangan-diperketat',
                'content' => '<p>Pemerintah melalui Badan Pengawas Obat dan Makanan (BPOM) mengeluarkan regulasi terbaru tentang keamanan pangan yang akan berlaku efektif mulai tahun depan. Regulasi ini bertujuan untuk meningkatkan standar keamanan produk pangan yang beredar di masyarakat.</p>

<p>Perubahan regulasi mencakup pengetatan pengawasan terhadap bahan tambahan pangan (BTP), pengaturan kadar maksimal residu pestisida, serta peningkatan frekuensi inspeksi terhadap fasilitas produksi pangan.</p>

<p>Pelaku usaha diharapkan dapat menyesuaikan diri dengan regulasi baru ini untuk menghindari sanksi administratif yang dapat mencapai ratusan juta rupiah.</p>',
                'excerpt' => 'Pemerintah melalui Badan Pengawas Obat dan Makanan (BPOM) mengeluarkan regulasi terbaru tentang keamanan pangan yang akan berlaku efektif mulai tahun depan...',
                'category' => 'berita',
                'status' => 'published',
                'is_featured' => true,
                'featured_image' => $featuredImages[2],
                'published_at' => Carbon::now()->subDays(3),
                'view_count' => rand(100, 300),
            ],
            [
                'title' => 'Tips Memilih Produk Pangan yang Aman untuk Konsumsi Sehari-hari',
                'slug' => 'tips-memilih-produk-pangan-yang-aman-untuk-konsumsi-sehari-hari',
                'content' => '<p>Memilih produk pangan yang aman merupakan hak dan tanggung jawab setiap konsumen. Berikut adalah beberapa tips praktis untuk memastikan produk pangan yang Anda beli aman untuk dikonsumsi:</p>

<ol>
<li><strong>Periksa Label</strong>: Selalu baca informasi pada kemasan, termasuk komposisi, tanggal kedaluwarsa, dan nomor registrasi BPOM.</li>
<li><strong>Pilih Produk Bersertifikasi</strong>: Utamakan produk yang memiliki sertifikasi halal dan SNI untuk menjamin kualitasnya.</li>
<li><strong>Perhatikan Kondisi Produk</strong>: Pastikan kemasan tidak rusak, tidak menggembung, dan tidak berubah warna.</li>
<li><strong>Beli dari Sumber Terpercaya</strong>: Pilih toko atau penjual yang terpercaya dan memiliki sistem penyimpanan yang baik.</li>
</ol>

<p>Dengan menerapkan tips-tips di atas, Anda dapat melindungi diri dan keluarga dari risiko kesehatan akibat mengonsumsi produk pangan yang tidak aman.</p>',
                'excerpt' => 'Memilih produk pangan yang aman merupakan hak dan tanggung jawab setiap konsumen. Berikut adalah beberapa tips praktis untuk memastikan produk pangan yang Anda beli aman...',
                'category' => 'pembinaan',
                'status' => 'published',
                'is_featured' => false,
                'featured_image' => $featuredImages[3],
                'published_at' => Carbon::now()->subDays(2),
                'view_count' => rand(75, 250),
            ],
            [
                'title' => 'Inovasi Produk Pangan Lokal Mendapat Apresiasi Internasional',
                'slug' => 'inovasi-produk-pangan-lokal-mendapat-apresiasi-internasional',
                'content' => '<p>Produk pangan lokal Indonesia semakin mendapat pengakuan di kancah internasional. Beberapa inovasi produk pangan dari pelaku UMKM berhasil meraih penghargaan dalam ajang pangan internasional yang diselenggarakan di Singapura bulan lalu.</p>

<p>Produk-produk inovatif seperti keripik buah dengan teknologi pengeringan modern dan minuman herbal fungsional mendapat apresiasi tinggi dari juri internasional. Keberhasilan ini membuktikan bahwa produk pangan Indonesia memiliki potensi besar untuk bersaing di pasar global.</p>

<p>Pencapaian ini diharapkan dapat menjadi motivasi bagi pelaku usaha pangan lainnya untuk terus berinovasi dan meningkatkan kualitas produk sesuai standar internasional.</p>',
                'excerpt' => 'Produk pangan lokal Indonesia semakin mendapat pengakuan di kancah internasional. Beberapa inovasi produk pangan dari pelaku UMKM berhasil meraih penghargaan...',
                'category' => 'berita',
                'status' => 'published',
                'is_featured' => false,
                'featured_image' => $featuredImages[4],
                'published_at' => Carbon::now()->subDays(1),
                'view_count' => rand(40, 180),
            ],
            [
                'title' => 'Pelatihan Higiene Sanitasi untuk Pelaku Usaha Pangan',
                'slug' => 'pelatihan-higiene-sanitasi-untuk-pelaku-usaha-pangan',
                'content' => '<p>Dinas Ketahanan Pangan setempat mengadakan pelatihan higiene sanitasi bagi pelaku usaha pangan di wilayah tersebut. Pelatihan ini diikuti oleh lebih dari 100 peserta yang berasal dari berbagai jenis usaha pangan, mulai dari rumah makan hingga industri pengolahan makanan skala kecil.</p>

<p>Materi pelatihan meliputi praktik higiene sanitasi yang benar, pengelolaan limbah, pencegahan kontaminasi silang, serta pemahaman tentang penyakit bawaan makanan. Para peserta juga mendapat sertifikasi setelah menyelesaikan pelatihan.</p>

<p>Kegiatan ini merupakan bagian dari upaya pemerintah dalam meningkatkan kesadaran dan kemampuan pelaku usaha pangan dalam menghasilkan produk yang aman dan berkualitas.</p>',
                'excerpt' => 'Dinas Ketahanan Pangan setempat mengadakan pelatihan higiene sanitasi bagi pelaku usaha pangan di wilayah tersebut. Pelatihan ini diikuti oleh lebih dari 100 peserta...',
                'category' => 'berita',
                'status' => 'published',
                'is_featured' => false,
                'featured_image' => $featuredImages[5],
                'published_at' => Carbon::now()->subDays(4),
                'view_count' => rand(25, 120),
            ]
        ];

        foreach ($articles as $articleData) {
            // Assign random admin user as author
            $articleData['author_id'] = $adminUsers->random()->id;

            Article::create($articleData);
        }

        $this->command->info('Successfully created ' . count($articles) . ' sample articles');
    }
}
