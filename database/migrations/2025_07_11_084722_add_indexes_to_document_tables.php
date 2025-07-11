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
        // Add indexes to documents table
        Schema::table('documents', function (Blueprint $table) {
            $table->index('title');
            $table->index('status');
            $table->index('uploaded_by');
            $table->index('category_id');
            $table->index('is_public');
            $table->index('is_featured');
            $table->index('created_at');
        });

        // Add indexes to document_downloads table
        Schema::table('document_downloads', function (Blueprint $table) {
            $table->index('document_id');
            $table->index('user_id');
            $table->index('downloaded_at');
        });

        // Add indexes to document_views table
        Schema::table('document_views', function (Blueprint $table) {
            $table->index('document_id');
            $table->index('user_id');
            $table->index('viewed_at');
        });

        // Add indexes to categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->index('parent_id');
            $table->index('is_active');
            $table->index('sort_order');
        });

        // Add indexes to tags table
        Schema::table('tags', function (Blueprint $table) {
            $table->index('usage_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove indexes from documents table
        Schema::table('documents', function (Blueprint $table) {
            $table->dropIndex(['title']);
            $table->dropIndex(['status']);
            $table->dropIndex(['uploaded_by']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['is_public']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['created_at']);
        });

        // Remove indexes from document_downloads table
        Schema::table('document_downloads', function (Blueprint $table) {
            $table->dropIndex(['document_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['downloaded_at']);
        });

        // Remove indexes from document_views table
        Schema::table('document_views', function (Blueprint $table) {
            $table->dropIndex(['document_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['viewed_at']);
        });

        // Remove indexes from categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['parent_id']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['sort_order']);
        });

        // Remove indexes from tags table
        Schema::table('tags', function (Blueprint $table) {
            $table->dropIndex(['usage_count']);
        });
    }
};
