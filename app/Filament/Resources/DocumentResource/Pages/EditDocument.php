<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Facades\Filament;

class EditDocument extends EditRecord
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(function (): bool {
                    $user = Filament::auth()->user();
                    return $user && $this->record->uploaded_by === $user->id;
                }),
        ];
    }

    protected function authorizeAccess(): void
    {
        $user = Filament::auth()->user();

        // Allow super admin (ID 1) to edit any document
        if ($user && $user->id === 1) {
            return;
        }

        // Check if user is the document owner
        if ($user && $this->record->uploaded_by === $user->id) {
            return;
        }

        // If not authorized, abort with 403
        abort(403, 'You are not authorized to edit this document.');
    }
}
