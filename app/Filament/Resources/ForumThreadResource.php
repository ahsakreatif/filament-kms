<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ForumThreadResource\Pages;
use App\Models\ForumThread;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Kirschbaum\Commentions\Filament\Infolists\Components\CommentsEntry;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\Action;
use Filament\Actions\Action as PageAction;

class ForumThreadResource extends Resource
{
    protected static ?string $model = ForumThread::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?string $navigationGroup = 'Forum';
    protected static ?string $navigationLabel = 'Threads';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make([
                    Forms\Components\TextInput::make('title')
                        ->label('Thread Title')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('forum_topic_id')
                        ->label('Topic')
                        ->relationship('topic', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\Select::make('category_id')
                        ->label('Category')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->nullable(),
                    Forms\Components\Select::make('tags')
                        ->label('Tags')
                        ->relationship('tags', 'name')
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->helperText('Select relevant tags for this thread.'),
                    Forms\Components\Select::make('documents')
                        ->label('Attach Documents')
                        ->relationship('documents', 'title')
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->helperText('Attach any relevant documents.'),
                    Forms\Components\RichEditor::make('body')
                        ->label('Thread Content')
                        ->required()
                        ->columnSpanFull()
                        ->toolbarButtons([
                            'bold', 'italic', 'underline', 'strike', 'link', 'bulletList', 'orderedList', 'blockquote', 'codeBlock', 'h2', 'h3', 'h4', 'hr', 'undo', 'redo',
                        ])
                        ->helperText('Write the main content of your thread.'),
                ])->columns(2),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Thread Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('title')
                            ->label('Thread Title')
                            ->size('lg')
                            ->weight('bold')
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('body')
                            ->label('Thread Content')
                            ->markdown()
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Infolists\Components\Section::make('Meta Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('topic.name')->label('Topic'),
                        Infolists\Components\TextEntry::make('category.name')->label('Category'),
                        Infolists\Components\TextEntry::make('tags.name')
                            ->label('Tags')
                            ->formatStateUsing(fn($state) => is_array($state) ? implode(', ', $state) : $state),
                        Infolists\Components\TextEntry::make('documents.title')
                            ->label('Attached Documents')
                            ->formatStateUsing(fn($state) => is_array($state) ? implode(', ', $state) : $state),
                        Infolists\Components\TextEntry::make('user.name')->label('Author'),
                        Infolists\Components\TextEntry::make('created_at')->label('Created At')->dateTime(),
                        Infolists\Components\TextEntry::make('updated_at')->label('Last Updated')->dateTime(),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Comments')
                    ->schema([
                        CommentsEntry::make('comments')
                            ->mentionables(fn (Model $record) => User::all())
                            ->label('Comments'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->wrap()
                    ->extraAttributes(['class' => 'whitespace-normal']),
                Tables\Columns\TextColumn::make('topic.name')
                    ->label('Topic')
                    ->sortable()
                    ->toggleable()
                    ->wrap()
                    ->extraAttributes(['class' => 'whitespace-normal'])
                    ->visibleFrom('md'),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->toggleable()
                    ->wrap()
                    ->extraAttributes(['class' => 'whitespace-normal']),
                Tables\Columns\TagsColumn::make('tags.name')
                    ->label('Tags')
                    ->toggleable()
                    ->wrap()
                    ->extraAttributes(['class' => 'whitespace-normal']),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Author')
                    ->sortable()
                    ->toggleable()
                    ->wrap()
                    ->extraAttributes(['class' => 'whitespace-normal']),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable()
                    ->wrap()
                    ->extraAttributes(['class' => 'whitespace-normal']),
            ])
            ->filters([

            ])
            ->actions([
                Action::make('forum_view')
                    ->label('Forum View')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->url(fn (ForumThread $record): string => ForumThreadResource::getUrl('forum-view', ['record' => $record])),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Add relation managers if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListForumThreads::route('/'),
            'create' => Pages\CreateForumThread::route('/create'),
            'edit' => Pages\EditForumThread::route('/{record}/edit'),
            'view' => Pages\ViewForumThread::route('/{record}'),
            'forum-view' => Pages\ForumViewThread::route('/{record}/forum-view'),
        ];
    }
}
