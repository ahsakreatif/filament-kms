<?php

namespace App\Console\Commands;

use App\Services\RecommendationService;
use Illuminate\Console\Command;

class CleanupUserPreferences extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recommendations:cleanup {--days=365 : Number of days old to consider for cleanup}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old user tag preferences';

    /**
     * Execute the console command.
     */
    public function handle(RecommendationService $recommendationService): int
    {
        $days = $this->option('days');

        $this->info("Cleaning up user preferences older than {$days} days...");

        $recommendationService->cleanupOldPreferences($days);

        $this->info('User preferences cleanup completed successfully.');

        return self::SUCCESS;
    }
}
