<?php

namespace App\Filament\Resources\ForumThreadResource\Pages;

use App\Filament\Resources\ForumThreadResource;
use App\Models\ForumThread;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;

class ForumViewThread extends ViewRecord
{
    protected static string $resource = ForumThreadResource::class;

    protected static string $view = 'filament.resources.forum-thread-resource.pages.forum-view-thread';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back_to_list')
                ->label('Back to Threads')
                ->url(ForumThreadResource::getUrl())
                ->color('gray'),
            Action::make('edit')
                ->label('Edit Thread')
                ->url(fn () => ForumThreadResource::getUrl('edit', ['record' => $this->record]))
                ->color('primary'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [];
    }
}
