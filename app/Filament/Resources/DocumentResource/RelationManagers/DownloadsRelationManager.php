<?php

namespace App\Filament\Resources\DocumentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DownloadsRelationManager extends RelationManager
{
    protected static string $relationship = 'downloads';

    protected static ?string $recordTitleAttribute = 'id';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user.name')
                    ->label('User')
                    ->disabled(),
                Forms\Components\TextInput::make('ip_address')
                    ->label('IP Address')
                    ->disabled(),
                Forms\Components\TextInput::make('user_agent')
                    ->label('User Agent')
                    ->disabled(),
                Forms\Components\DateTimePicker::make('downloaded_at')
                    ->label('Download Time')
                    ->disabled(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_agent')
                    ->label('User Agent')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->user_agent),
                Tables\Columns\TextColumn::make('downloaded_at')
                    ->label('Download Time')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('with_user')
                    ->label('With User Account')
                    ->query(fn (Builder $query) => $query->whereNotNull('user_id')),
                Tables\Filters\Filter::make('anonymous')
                    ->label('Anonymous Downloads')
                    ->query(fn (Builder $query) => $query->whereNull('user_id')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('downloaded_at', 'desc');
    }
}
