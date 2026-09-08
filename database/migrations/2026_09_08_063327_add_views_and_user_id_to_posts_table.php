<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('views')->default(0)->after('is_published');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null')->after('id');
        });

        // Assign all existing posts to the first user if exists
        $user = \App\Models\User::first();
        if ($user) {
            \App\Models\Post::whereNull('user_id')->update(['user_id' => $user->id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['views', 'user_id']);
        });
    }
};
