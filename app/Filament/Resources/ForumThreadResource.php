<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ForumThreadResource\Pages;
use App\Models\ForumThread;
use App\Models\User;
use App\Services\ForumThreadStatsService;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
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
use Filament\Tables\Actions\ActionGroup;
use Filament\Notifications\Notification;

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

                Infolists\Components\Section::make('Statistics')
                    ->schema([
                        Infolists\Components\TextEntry::make('likes_count')
                            ->label('Total Likes')
                            ->icon('heroicon-o-heart')
                            ->color('danger'),
                        Infolists\Components\TextEntry::make('views_count')
                            ->label('Total Views')
                            ->icon('heroicon-o-eye')
                            ->color('info'),
                        Infolists\Components\TextEntry::make('unique_views_count')
                            ->label('Unique Views')
                            ->icon('heroicon-o-users')
                            ->color('success'),
                        Infolists\Components\TextEntry::make('is_liked_by_current_user')
                            ->label('Liked by You')
                            ->state(function (ForumThread $record): string {
                                return $record->isLikedByCurrentUser() ? 'Yes' : 'No';
                            })
                            ->icon('heroicon-o-heart')
                            ->color(fn (ForumThread $record): string => $record->isLikedByCurrentUser() ? 'danger' : 'gray'),
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
                Tables\Columns\ImageColumn::make('user.avatar_url')
                    ->label('Author')
                    ->circular()
                    ->defaultImageUrl(function ($record) {
                        $initials = collect(explode(' ', $record->user->name))->map(function ($segment) {
                            return strtoupper(substr($segment, 0, 1));
                        })->join('');
                        return 'https://ui-avatars.com/api/?name=' . urlencode($initials) . '&color=FFFFFF&background=111827';
                    })
                    ->sortable()
                    ->toggleable()
                    ->width('40px'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->weight('bold')
                    ->grow(),
                /* Tables\Columns\TagsColumn::make('tags.name')
                    ->label('Tags')
                    ->toggleable()
                    ->color('gray')
                    ->visibleFrom('md'), */
                Tables\Columns\TextColumn::make('topic.name')
                    ->label('Topic')
                    ->sortable()
                    ->toggleable()
                    ->wrap()
                    ->badge()
                    ->visibleFrom('md'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->toggleable()
                    // ->wrap()
                    ->visibleFrom('lg'),
                Tables\Columns\TextColumn::make('likes_count')
                    ->label('Likes')
                    ->sortable()
                    ->toggleable()
                    ->icon('heroicon-o-heart')
                    ->color('danger')
                    ->width('80px')
                    ->formatStateUsing(fn (ForumThread $record) => $record->likes_count ?? 0),
                Tables\Columns\TextColumn::make('views_count')
                    ->label('Views')
                    ->sortable()
                    ->toggleable()
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->width('80px')
                    ->formatStateUsing(fn (ForumThread $record) => $record->views_count ?? 0),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('topic_id')
                    ->label('Topic')
                    ->relationship('topic', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('tags')
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Action::make('like')
                        ->label(fn (ForumThread $record): string => $record->isLikedByCurrentUser() ? 'Unlike' : 'Like')
                        ->icon(fn (ForumThread $record): string => $record->isLikedByCurrentUser() ? 'heroicon-o-heart' : 'heroicon-o-heart')
                        ->color(fn (ForumThread $record): string => $record->isLikedByCurrentUser() ? 'danger' : 'gray')
                        ->action(function (ForumThread $record) {
                            $isLiked = $record->toggleLike();
                            $message = $isLiked ? 'Thread liked successfully!' : 'Thread unliked successfully!';

                            Notification::make()
                                ->title($message)
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation()
                        ->modalHeading(fn (ForumThread $record): string => $record->isLikedByCurrentUser() ? 'Unlike Thread' : 'Like Thread')
                        ->modalDescription(fn (ForumThread $record): string => $record->isLikedByCurrentUser()
                            ? 'Are you sure you want to unlike this thread?'
                            : 'Are you sure you want to like this thread?'),
                ])
                ->icon('heroicon-m-ellipsis-vertical')
                ->tooltip('Thread Actions'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->recordUrl(fn (ForumThread $record): string => ForumThreadResource::getUrl('view', ['record' => $record]))
            ->defaultSort('created_at', 'desc');
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
            // 'view' => Pages\ViewForumThread::route('/{record}'),
            'view' => Pages\ForumViewThread::route('/{record}'),
            'stats' => Pages\ThreadStats::route('/{record}/stats'),
        ];
    }
}
