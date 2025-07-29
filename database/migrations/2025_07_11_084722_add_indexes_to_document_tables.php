<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
        // Only drop indexes that are safe to remove (not foreign key indexes)
        Schema::table('documents', function (Blueprint $table) {
            $this->dropIndexIfExists($table, 'documents_title_index');
            $this->dropIndexIfExists($table, 'documents_status_index');
            $this->dropIndexIfExists($table, 'documents_is_public_index');
            $this->dropIndexIfExists($table, 'documents_is_featured_index');
            $this->dropIndexIfExists($table, 'documents_created_at_index');
        });

        // Only drop timestamp indexes from document_downloads table
        Schema::table('document_downloads', function (Blueprint $table) {
            $this->dropIndexIfExists($table, 'document_downloads_downloaded_at_index');
        });

        // Only drop timestamp indexes from document_views table
        Schema::table('document_views', function (Blueprint $table) {
            $this->dropIndexIfExists($table, 'document_views_viewed_at_index');
        });

        // Only drop safe indexes from categories table
        Schema::table('categories', function (Blueprint $table) {
            $this->dropIndexIfExists($table, 'categories_is_active_index');
            $this->dropIndexIfExists($table, 'categories_sort_order_index');
        });

        // Drop usage_count index from tags table
        Schema::table('tags', function (Blueprint $table) {
            $this->dropIndexIfExists($table, 'tags_usage_count_index');
        });
    }

    /**
     * Drop an index if it exists
     */
    private function dropIndexIfExists(Blueprint $table, string $indexName): void
    {
        try {
            $indexes = $this->getIndexes($table->getTable());
            if (in_array($indexName, $indexes)) {
                $table->dropIndex($indexName);
            }
        } catch (\Exception $e) {
            // Silently ignore if index doesn't exist or can't be dropped
            // This prevents migration failures due to missing indexes
        }
    }

    /**
     * Get all indexes for a table
     */
    private function getIndexes(string $tableName): array
    {
        $indexes = [];
        $results = DB::select("SHOW INDEX FROM {$tableName}");

        foreach ($results as $result) {
            if ($result->Key_name !== 'PRIMARY') {
                $indexes[] = $result->Key_name;
            }
        }

        return array_unique($indexes);
    }
};
