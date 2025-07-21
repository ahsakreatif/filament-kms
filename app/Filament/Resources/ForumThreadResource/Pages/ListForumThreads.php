<?php

namespace App\Filament\Resources\ForumThreadResource\Pages;

use App\Filament\Resources\ForumThreadResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListForumThreads extends ListRecords
{
    protected static string $resource = ForumThreadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
} 