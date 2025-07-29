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
        Schema::table('forum_threads', function (Blueprint $table) {
            $table->unsignedInteger('likes_count')->default(0)->after('user_id');
            $table->unsignedInteger('views_count')->default(0)->after('likes_count');
            $table->unsignedInteger('unique_views_count')->default(0)->after('views_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forum_threads', function (Blueprint $table) {
            $table->dropColumn(['likes_count', 'views_count', 'unique_views_count']);
        });
    }
};
