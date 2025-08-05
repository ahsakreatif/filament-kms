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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title', 500);
            $table->string('slug', 500)->unique();
            $table->text('description')->nullable();
            $table->text('abstract')->nullable();
            $table->string('file_path', 500);
            $table->string('file_name', 255);
            $table->bigInteger('file_size');
            $table->string('file_type', 100);
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('uploaded_by');
            $table->string('author', 255)->nullable();
            $table->text('keywords')->nullable();
            $table->integer('publication_year')->nullable();
            $table->string('doi', 255)->nullable();
            $table->string('isbn', 50)->nullable();
            $table->string('language', 10)->default('id');
            $table->boolean('is_public')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('downloads_count')->default(0);
            $table->integer('view_count')->default(0);
            $table->enum('status', ['draft', 'published', 'archived', 'flagged'])->default('published');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('restrict');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
