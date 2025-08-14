<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action as NotificationAction;

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
            Actions\Action::make('favorite')
                ->icon(fn () => $this->record->isFavoritedByCurrentUser() ? 'heroicon-o-star' : 'heroicon-o-star')
                ->label(fn () => $this->record->isFavoritedByCurrentUser() ? 'Unfavorite Document' : 'Favorite Document')
                ->color(fn () => $this->record->isFavoritedByCurrentUser() ? 'warning' : 'primary')
                ->action(function () {
                    $isFavorited = $this->record->toggleFavorite();
                    $message = $isFavorited ? 'Document favorited successfully!' : 'Document unfavorited successfully!';

                    Notification::make()
                        ->title($message)
                        ->success()
                        ->send();

                    $documentOwner = $this->record->uploadedBy;
                    $currentUser = Filament::auth()->user();
                    if ($documentOwner && $currentUser && $documentOwner->getKey() !== $currentUser->getKey() && $isFavorited) {
                        $documentOwner->notify(
                            Notification::make()
                                ->title('Your document has been favorited!')
                                ->body('Someone favorited your document "' . $this->record->title . '"')
                                ->actions([
                                    NotificationAction::make('view')
                                        ->label('View Document')
                                        ->url(fn () => DocumentResource::getUrl('view', ['record' => $this->record]))
                                        ->color('primary')
                                        ->icon('heroicon-o-eye'),
                                ])
                                ->icon('heroicon-o-star')
                                ->toDatabase(),
                        );
                        $documentOwner->notify(
                            Notification::make()
                                ->title('Your document has been favorited!')
                                ->icon('heroicon-o-star')
                                ->toBroadcast(),
                        );
                    }
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
