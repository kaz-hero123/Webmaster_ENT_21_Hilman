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

        // Tambahan Dummy Users
        \App\Models\User::factory(5)->create();

        // Kategori Berita
        $categories = ['Seputar Kampus', 'Teknologi & Inovasi', 'Olahraga & E-Sports', 'Opini Mahasiswa', 'Pengumuman'];
        foreach ($categories as $cat) {
            \App\Models\Category::create([
                'name' => $cat,
                'slug' => \Illuminate\Support\Str::slug($cat)
            ]);
        }

        // Generate 50 Dummy Posts
        \App\Models\Post::factory(50)->create();
    }
}
