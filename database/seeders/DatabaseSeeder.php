<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminSeeder::class);

        // Kategori Berita
        $katKampus = \App\Models\Category::create(['name' => 'Seputar Kampus']);
        $katTeknologi = \App\Models\Category::create(['name' => 'Teknologi & Inovasi']);
        $katOlahraga = \App\Models\Category::create(['name' => 'Olahraga & E-Sports']);
        $katOpini = \App\Models\Category::create(['name' => 'Opini Mahasiswa']);

        $now = Carbon::now();

        // Data Berita 1
        \App\Models\Post::create([
            'title' => 'Tim Robotika PENS Kembali Rajai Kontes Robot Nasional',
            'content' => "SURABAYA, ENT - Tim Robotika Politeknik Elektronika Negeri Surabaya (PENS) kembali mengharumkan nama almamater dengan menyapu bersih juara pertama pada ajang Kontes Robot Nasional (KRN).\n\nDalam kompetisi yang berlangsung akhir pekan lalu, tim PENS berhasil mengalahkan lebih dari 50 perguruan tinggi lainnya. Kemenangan ini didorong oleh inovasi terbaru pada sistem kecerdasan buatan (AI) yang disematkan pada robot mereka.\n\n\"Kami mempersiapkan ini selama 6 bulan penuh. Terima kasih atas dukungan kampus dan seluruh mahasiswa,\" ujar Budi, ketua tim divisi terkait.",
            'category_id' => $katTeknologi->id,
            'image' => null, 
            'created_at' => $now->copy()->subDays(2),
        ]);

        // Data Berita 2
        \App\Models\Post::create([
            'title' => 'Kemeriahan Malam Puncak EEPIS Anniversary',
            'content' => "SURABAYA, ENT - Malam puncak perayaan ulang tahun PENS berlangsung sangat meriah pada Sabtu malam di lapangan merah. Acara ini dihadiri oleh ribuan mahasiswa, dosen, serta alumni yang antusias mengikuti rangkaian kegiatan.\n\nAcara dibuka dengan sambutan Direktur PENS dan dilanjutkan dengan penampilan memukau dari berbagai Unit Kegiatan Mahasiswa (UKM) bidang seni. Tidak ketinggalan, guest star turut memeriahkan panggung utama hingga larut malam.\n\n\"Harapannya PENS semakin maju dan terus melahirkan inovator muda yang berdampak bagi bangsa,\" pungkas salah satu alumni yang hadir.",
            'category_id' => $katKampus->id,
            'image' => null,
            'created_at' => $now->copy()->subDays(1),
        ]);

        // Data Berita 3
        \App\Models\Post::create([
            'title' => 'Mahasiswa IT Kembangkan Aplikasi Pemantau Kualitas Udara Real-time',
            'content' => "SURABAYA, ENT - Kualitas udara yang kian memburuk memicu keprihatinan sekelompok mahasiswa jurusan Teknik Informatika PENS. Mereka berhasil mengembangkan aplikasi pemantau kualitas udara berbasis Internet of Things (IoT).\n\nAplikasi yang diberi nama 'AirPENS' ini tidak hanya menampilkan indeks polusi, tetapi juga memberikan notifikasi otomatis ke smartphone pengguna jika kualitas udara di sekitarnya mencapai level berbahaya.\n\nMenurut dosen pembimbing proyek ini, aplikasi AirPENS akan segera diluncurkan versi betanya agar bisa diuji coba langsung oleh seluruh civitas akademika.",
            'category_id' => $katTeknologi->id,
            'image' => null,
            'created_at' => $now->copy()->subHours(12),
        ]);

        // Data Berita 4
        \App\Models\Post::create([
            'title' => 'UKM E-Sports PENS Juarai Turnamen Tingkat Regional',
            'content' => "SURABAYA, ENT - Prestasi gemilang kembali diraih oleh mahasiswa PENS. Kali ini, delegasi dari Unit Kegiatan Mahasiswa (UKM) E-Sports berhasil membawa pulang piala juara satu pada Turnamen mahasiswa regional Jawa Timur.\n\nPertandingan final yang berlangsung dramatis dengan skor 3-2 tersebut menjadi bukti bahwa mahasiswa PENS tidak hanya ahli dalam coding, tetapi juga piawai dalam mengatur strategi permainan di kancah E-Sports.\n\nKemenangan ini diharapkan menjadi motivasi bagi mahasiswa lain untuk terus berprestasi di bidang non-akademik.",
            'category_id' => $katOlahraga->id,
            'image' => null,
            'created_at' => $now->copy()->subHours(5),
        ]);
        
        // Data Berita 5
        \App\Models\Post::create([
            'title' => 'Menjaga Keseimbangan Kuliah dan Organisasi: Mungkinkah?',
            'content' => "SURABAYA, ENT - Seringkali mahasiswa terjebak dalam dilema antara fokus mengejar IPK tinggi atau aktif berorganisasi. Namun, apakah keduanya benar-benar tidak bisa sejalan?\n\nBanyak alumni sukses membuktikan bahwa manajemen waktu adalah kunci utama. Dengan menyusun jadwal prioritas yang baik, mahasiswa bisa mendapatkan hard skill dari ruang kelas dan soft skill dari organisasi.\n\nArtikel opini kali ini mengupas tuntas tips dan trik manajemen waktu dari Presiden BEM PENS periode lalu yang berhasil lulus dengan predikat Cumlaude meski disibukkan dengan berbagai program kerja.",
            'category_id' => $katOpini->id,
            'image' => null,
            'created_at' => $now->copy()->subMinutes(30),
        ]);
        
        // Data Berita 6
        \App\Models\Post::create([
            'title' => 'Open Recruitment EEPIS News and Network Team Resmi Dibuka!',
            'content' => "SURABAYA, ENT - Kabar gembira bagi kamu mahasiswa PENS yang memiliki passion di bidang jurnalistik, fotografi, penyiaran, maupun web development! EEPIS News and Network Team (ENT) resmi membuka pendaftaran anggota baru (Open Recruitment) tahun ini.\n\nENT merupakan satu-satunya organisasi pers kampus di PENS yang menjadi wadah bagi mahasiswa untuk mengembangkan kreativitas di bidang media massa dan teknologi informasi.\n\nJangan lewatkan kesempatan berharga ini. Segera daftarkan dirimu melalui tautan resmi ENT dan bersiaplah menjadi bagian dari kru media kampus terbaik!",
            'category_id' => $katKampus->id,
            'image' => null,
            'created_at' => $now,
        ]);
    }
}
