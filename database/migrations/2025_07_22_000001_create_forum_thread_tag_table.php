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
        Schema::create('forum_thread_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('forum_thread_id');
            $table->unsignedBigInteger('tag_id');
            $table->primary(['forum_thread_id', 'tag_id']);

            $table->foreign('forum_thread_id')->references('id')->on('forum_threads')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_thread_tag');
    }
}; 