<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Facades\Filament;

class ViewDocument extends ViewRecord
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('download')
                ->icon('heroicon-o-arrow-down-tray')
                ->label('Download Document')
                ->url(fn () => $this->record->file_path ? url('storage/' . $this->record->file_path) : null)
                ->openUrlInNewTab()
                ->visible(fn () => $this->record->file_path),
            Actions\Action::make('approve')
                ->icon('heroicon-o-check-circle')
                ->label('Approve Document')
                ->color('success')
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update([
                        'status' => 'published',
                        'approved_by' => Filament::auth()->id(),
                        'approved_at' => now(),
                    ]);

                    $this->notify('success', 'Document approved successfully.');
                })
                ->visible(fn () => $this->record->status !== 'published'),
        ];
    }
}
