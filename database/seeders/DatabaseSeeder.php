<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $kategoriPolitik = \App\Models\Category::create(['name' => 'Politik']);
        $kategoriTeknologi = \App\Models\Category::create(['name' => 'Teknologi']);
        $kategoriOlahraga = \App\Models\Category::create(['name' => 'Olahraga']);

        \App\Models\Post::create([
            'title' => 'Pemilihan Ketua BEM Terlaksana Damai',
            'content' => 'Acara pemilihan ketua BEM kampus hari ini berjalan dengan sangat lancar dan damai. Seluruh mahasiswa antusias.',
            'category_id' => $kategoriPolitik->id,
            'image' => null, 
        ]);

        \App\Models\Post::create([
            'title' => 'AI Mengubah Cara Mahasiswa Belajar',
            'content' => 'Kehadiran Artificial Intelligence membuat mahasiswa harus lebih pintar beradaptasi agar tidak tertinggal.',
            'category_id' => $kategoriTeknologi->id,
            'image' => null,
        ]);

        \App\Models\Post::create([
            'title' => 'Tim Futsal Kampus Menang Telak',
            'content' => 'Pertandingan final futsal antar jurusan kemarin dimenangkan oleh jurusan kita dengan skor 5-1.',
            'category_id' => $kategoriOlahraga->id,
            'image' => null,
        ]);
    }
}
