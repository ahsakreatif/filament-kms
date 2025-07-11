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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DocumentResource extends Resource
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
                    ])->columns(3),
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
                Tables\Columns\TextColumn::make('download_count')
                    ->sortable(),
                Tables\Columns\TextColumn::make('view_count')
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
                Tables\Actions\EditAction::make(),
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
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
