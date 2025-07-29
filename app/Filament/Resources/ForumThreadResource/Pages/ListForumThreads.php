<?php

namespace App\Filament\Resources\ForumThreadResource\Pages;

use App\Filament\Resources\ForumThreadResource;
use App\Filament\Widgets\ForumThreadStatsWidget;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
use Illuminate\Database\Eloquent\Model;

class ListForumThreads extends ListRecords
{
    protected static string $resource = ForumThreadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getRecordUrl(Model $record): string
    {
        return $this->getResource()::getUrl('view', ['record' => $record]);
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ForumThreadStatsWidget::class,
        ];
    }
}
