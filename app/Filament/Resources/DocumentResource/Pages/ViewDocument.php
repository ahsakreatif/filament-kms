<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Facades\Filament;
use Filament\Forms;

class ViewDocument extends ViewRecord
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->visible(function (): bool {
                    $user = Filament::auth()->user();
                    return $user && $this->record->uploaded_by === $user->id;
                }),
            Actions\Action::make('download')
                ->icon('heroicon-o-arrow-down-tray')
                ->label('Download Document')
                ->url(fn () => $this->record->file_path ? url('storage/' . $this->record->file_path) : null)
                ->openUrlInNewTab()
                ->visible(fn () => $this->record->file_path),
            Actions\Action::make('status')
                ->icon('heroicon-o-document-check')
                ->label('Change Status')
                ->form([
                    Forms\Components\Select::make('status')
                        ->label('Document Status')
                        ->options([
                            'draft' => 'Draft',
                            'published' => 'Published',
                            'archived' => 'Archived',
                            'flagged' => 'Flagged'
                        ])
                        ->required()
                        ->default(fn () => $this->record->status)
                ])
                ->action(function (array $data) {
                    $this->record->update([
                        'status' => $data['status'],
                        'approved_by' => Filament::auth()->id(),
                        'approved_at' => now(),
                    ]);

                    $this->notify('success', 'Document status updated successfully.');
                })
                ->visible(fn () => Filament::auth()->user()->can('publish_document'))
                ->requiresConfirmation()
                ->modalHeading('Change Document Status')
                ->modalDescription('Are you sure you want to change the status of this document?'),
        ];
    }
}
