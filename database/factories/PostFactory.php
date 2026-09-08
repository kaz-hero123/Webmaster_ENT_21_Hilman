<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subjects = ['Mahasiswa PENS', 'Tim Robotika', 'UKM E-Sports', 'Pemerintah', 'Dosen IT', 'Alumni', 'Kementerian Pendidikan', 'Ahli Teknologi', 'Peneliti', 'Gubernur Jatim'];
        $verbs = ['Kembangkan', 'Resmikan', 'Raih Juara di', 'Bahas Potensi', 'Luncurkan', 'Ciptakan', 'Gelar Seminar tentang', 'Temukan Solusi untuk', 'Soroti Masalah', 'Buka Pendaftaran'];
        $objects = ['Aplikasi Baru', 'Kontes Nasional', 'Kecerdasan Buatan', 'Sistem IoT', 'Beasiswa Pendidikan', 'Pencemaran Lingkungan', 'Kompetisi Startup', 'Teknologi Ramah Lingkungan', 'Program Kerja', 'Inovasi Digital'];

        $title = fake()->randomElement($subjects) . ' ' . fake()->randomElement($verbs) . ' ' . fake()->randomElement($objects) . ' ' . rand(2023, 2026);
        $is_published = fake()->boolean(80); // 80% published
        
        $indoParagraphs = [
            "Pendidikan adalah kunci utama untuk mencapai masa depan yang lebih cerah. Banyak ahli berpendapat bahwa sistem pendidikan saat ini harus terus beradaptasi dengan perkembangan teknologi.",
            "Dalam era digital, informasi menyebar dengan sangat cepat. Oleh karena itu, penting bagi kita untuk selalu memverifikasi kebenaran sebuah berita sebelum membagikannya ke orang lain.",
            "Pemerintah baru saja mengumumkan kebijakan baru terkait subsidi pendidikan. Kebijakan ini diharapkan dapat membantu mahasiswa dari keluarga kurang mampu untuk tetap melanjutkan studi mereka tanpa hambatan finansial.",
            "Selain itu, kegiatan ekstrakurikuler di kampus juga memegang peranan penting. Organisasi mahasiswa memberikan wadah bagi para pemuda untuk mengasah kemampuan kepemimpinan dan kerja sama tim.",
            "Banyak perusahaan kini lebih mencari lulusan yang tidak hanya unggul secara akademik, tetapi juga memiliki soft skill yang mumpuni. Pengalaman berorganisasi seringkali menjadi nilai tambah di mata rekruter.",
            "Perkembangan kecerdasan buatan (AI) belakangan ini mengundang banyak perdebatan. Sebagian pihak merasa khawatir AI akan menggantikan pekerjaan manusia, sementara yang lain melihatnya sebagai alat bantu yang luar biasa.",
            "Di sisi lain, masalah lingkungan hidup juga semakin mendesak. Kampanye pengurangan sampah plastik di lingkungan kampus telah menunjukkan hasil yang positif dalam beberapa bulan terakhir.",
            "Kegiatan olahraga di akhir pekan menjadi rutinitas baru bagi sebagian mahasiswa. Selain menjaga kebugaran tubuh, olahraga juga dinilai efektif untuk mengurangi tingkat stres akibat beban tugas kuliah yang menumpuk.",
            "Dengan adanya berbagai inovasi yang terus bermunculan, persaingan di dunia kerja dipastikan akan semakin ketat. Oleh sebab itu, mahasiswa dituntut untuk terus memperbarui keterampilan mereka setiap saat.",
            "Sebagai penutup, sinergi antara dunia akademik dan industri harus terus ditingkatkan. Hanya dengan kolaborasi yang baik, kita bisa menciptakan inovasi yang benar-benar bermanfaat bagi masyarakat luas."
        ];

        shuffle($indoParagraphs);
        $selectedParagraphs = array_slice($indoParagraphs, 0, rand(3, 6));
        
        $content = '';
        foreach ($selectedParagraphs as $para) {
            $content .= "<p>$para</p>";
        }

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(5),
            'excerpt' => fake()->randomElement($indoParagraphs),
            'content' => $content,
            'image' => null, // We'll leave image null so fallback works
            'is_published' => $is_published,
            'published_at' => $is_published ? fake()->dateTimeBetween('-1 year', 'now') : null,
            'views' => fake()->numberBetween(0, 5000),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
        ];
    }
}
