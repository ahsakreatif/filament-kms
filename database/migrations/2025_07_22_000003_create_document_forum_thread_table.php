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
        Schema::create('document_forum_thread', function (Blueprint $table) {
            $table->unsignedBigInteger('forum_thread_id');
            $table->unsignedBigInteger('document_id');
            $table->primary(['forum_thread_id', 'document_id']);

            $table->foreign('forum_thread_id')->references('id')->on('forum_threads')->onDelete('cascade');
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_forum_thread');
    }
}; 