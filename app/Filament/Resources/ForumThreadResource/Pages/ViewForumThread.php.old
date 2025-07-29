<?php

namespace App\Filament\Resources\ForumThreadResource\Pages;

use App\Filament\Resources\ForumThreadResource;
use App\Models\ForumThread;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;

class ViewForumThread extends ViewRecord
{
    protected static string $resource = ForumThreadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('forum_view')
                ->label('Forum View')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->color('primary')
                ->url(fn () => ForumThreadResource::getUrl('forum-view', ['record' => $this->record]))
                ->openUrlInNewTab(),
            $this->getEditAction(),
        ];
    }
}
