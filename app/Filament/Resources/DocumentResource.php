<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Filament\Resources\DocumentResource\RelationManagers;
use App\Models\Document;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Filament\Forms;
use Filament\Facades\Filament;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;

class DocumentResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Documents';
    protected static ?string $navigationGroup = 'Document Management';
    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['category', 'uploadedBy', 'tags']);
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()
            ->with(['category', 'uploadedBy', 'tags']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'title',
            'description',
            'abstract',
            'author',
            'keywords',
            'doi',
            'isbn',
            'category.name',
            'uploadedBy.name',
            'tags.name',
        ];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Category' => $record->category?->name,
            'Uploader' => $record->uploadedBy?->name,
            'Tags' => $record->tags->pluck('name')->implode(', '),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'restore',
            'restore_any',
            'replicate',
            'reorder',
            'delete',
            'delete_any',
            'force_delete',
            'force_delete_any',
            'lock',
            'publish'
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(500),
                        Forms\Components\TextInput::make('slug')
                            ->maxLength(500)
                            ->helperText('Leave empty to auto-generate from title'),
                        Forms\Components\Textarea::make('description')
                            ->rows(3),
                        Forms\Components\Textarea::make('abstract')
                            ->rows(4),
                    ])->columns(2),

                Forms\Components\Section::make('File Upload')
                    ->schema([
                        Forms\Components\FileUpload::make('file_path')
                            ->label('Document File')
                            ->downloadable()
                            ->required()
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'])
                            ->maxSize(50 * 1024) // 50MB
                            ->directory('documents')
                            ->disabled(fn ($context) => $context === 'edit'),
                    ]),

                Forms\Components\Section::make('Classification')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('tags')
                            ->label('Tags')
                            ->relationship('tags', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable(),
                    ])->columns(2),

                Forms\Components\Section::make('Publication Details')
                    ->schema([
                        Forms\Components\TextInput::make('author')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('keywords')
                            ->rows(2),
                        Forms\Components\TextInput::make('publication_year')
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(date('Y') + 1),
                        Forms\Components\TextInput::make('doi')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('isbn')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('language')
                            ->maxLength(10)
                            ->default('id'),
                    ])->columns(2),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived',
                                'flagged' => 'Flagged',
                            ])
                            ->default('published')
                            ->required(),
                        Forms\Components\Toggle::make('is_public')
                            ->label('Public Document')
                            ->default(true),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured Document')
                            ->default(false),
                    ])->columns(3)
                    ->visible(fn () => auth()->user()->can('publish')),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Basic Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('title')
                            ->label('Document Title')
                            ->size('lg')
                            ->weight('bold')
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('description')
                            ->label('Description')
                            ->markdown()
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('abstract')
                            ->label('Abstract')
                            ->markdown()
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('slug')
                            ->label('Slug'),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('File Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('file_name')
                            ->label('File Name'),
                        Infolists\Components\TextEntry::make('file_size')
                            ->label('File Size')
                            ->formatStateUsing(fn ($state) => $state ? number_format($state / 1024, 2) . ' KB' : 'N/A'),
                        Infolists\Components\TextEntry::make('file_type')
                            ->label('File Type')
                            ->formatStateUsing(fn ($state) => strtoupper($state)),
                        Infolists\Components\TextEntry::make('mime_type')
                            ->label('MIME Type'),
                        Infolists\Components\TextEntry::make('file_path')
                            ->label('File Path')
                            ->url(fn ($state) => $state ? url('storage/' . $state) : null)
                            ->openUrlInNewTab(),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Classification')
                    ->schema([
                        Infolists\Components\TextEntry::make('category.name')
                            ->label('Category'),
                        Infolists\Components\TextEntry::make('tags.name')
                            ->label('Tags')
                            ->formatStateUsing(fn ($state) => is_array($state) ? implode(', ', $state) : $state),
                        Infolists\Components\TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'draft' => 'gray',
                                'published' => 'success',
                                'archived' => 'warning',
                                'flagged' => 'danger',
                            }),
                    ])
                    ->columns(3),

                Infolists\Components\Section::make('Publication Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('author')
                            ->label('Author'),
                        Infolists\Components\TextEntry::make('keywords')
                            ->label('Keywords'),
                        Infolists\Components\TextEntry::make('publication_year')
                            ->label('Publication Year'),
                        Infolists\Components\TextEntry::make('doi')
                            ->label('DOI'),
                        Infolists\Components\TextEntry::make('isbn')
                            ->label('ISBN'),
                        Infolists\Components\TextEntry::make('language')
                            ->label('Language'),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Settings & Statistics')
                    ->schema([
                        Infolists\Components\IconEntry::make('is_public')
                            ->label('Public Document')
                            ->boolean()
                            ->trueIcon('heroicon-o-eye')
                            ->falseIcon('heroicon-o-eye-slash'),
                        Infolists\Components\IconEntry::make('is_featured')
                            ->label('Featured Document')
                            ->boolean()
                            ->trueIcon('heroicon-o-star')
                            ->falseIcon('heroicon-o-star'),
                        Infolists\Components\TextEntry::make('downloads_count')
                            ->label('Downloads')
                            ->icon('heroicon-o-arrow-down-tray'),
                        Infolists\Components\TextEntry::make('favorites_count')
                            ->label('Favorites')
                            ->icon('heroicon-o-heart'),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('User Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('uploadedBy.name')
                            ->label('Uploaded By'),
                        Infolists\Components\TextEntry::make('approvedBy.name')
                            ->label('Approved By'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime(),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->dateTime(),
                        Infolists\Components\TextEntry::make('approved_at')
                            ->label('Approved At')
                            ->dateTime(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(30)
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable(),
                Tables\Columns\TextColumn::make('uploadedBy.name')
                    ->label('Uploader')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                        'archived' => 'warning',
                        'flagged' => 'danger',
                    })
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_public')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('downloads_count')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->sortable(),
                Tables\Columns\TextColumn::make('favorites_count')
                    ->icon('heroicon-o-heart')
                    ->color('danger')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                        'flagged' => 'Flagged',
                    ]),
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_public')
                    ->label('Public Documents'),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured Documents'),
                Tables\Filters\Filter::make('search')
                    ->form([
                        Forms\Components\TextInput::make('search')
                            ->label('Search')
                            ->placeholder('Search by title, description, author, tags...'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->where(function (Builder $query) use ($data) {
                                $search = $data['search'] ?? '';
                                if ($search) {
                                    $query->where('title', 'like', "%{$search}%")
                                        ->orWhere('description', 'like', "%{$search}%")
                                        ->orWhere('abstract', 'like', "%{$search}%")
                                        ->orWhere('author', 'like', "%{$search}%")
                                        ->orWhere('keywords', 'like', "%{$search}%")
                                        ->orWhereHas('tags', function (Builder $query) use ($search) {
                                            $query->where('name', 'like', "%{$search}%");
                                        })
                                        ->orWhereHas('category', function (Builder $query) use ($search) {
                                            $query->where('name', 'like', "%{$search}%");
                                        });
                                }
                            });
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                                                Tables\Actions\EditAction::make()
                    ->visible(function (Document $record): bool {
                        $user = Filament::auth()->user();
                        return $user && $record->uploaded_by === $user->id;
                    }),
                Tables\Actions\DeleteAction::make()
                    ->visible(function (Document $record): bool {
                        $user = Filament::auth()->user();
                        return $user && $record->uploaded_by === $user->id;
                    }),
                Tables\Actions\Action::make('approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Document $record) {
                        $record->update([
                            'status' => 'published',
                            'approved_by' => Filament::auth()->id(),
                            'approved_at' => now(),
                        ]);
                    })
                    ->visible(fn (Document $record): bool => $record->status !== 'published'),
                Tables\Actions\Action::make('download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Document $record): string => $record->file_path)
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(function (): bool {
                            $user = Filament::auth()->user();
                            return $user && $user->id === 1; // Only super admin (ID 1) can bulk delete
                        }),
                ]),
            ])
            ->recordUrl(fn (Document $record): string => DocumentResource::getUrl('view', ['record' => $record]))
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\DownloadsRelationManager::class,
            RelationManagers\ViewsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'view' => Pages\ViewDocument::route('/{record}'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
