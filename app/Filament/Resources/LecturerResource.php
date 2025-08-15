<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LecturerResource\Pages;
use App\Filament\Resources\LecturerResource\RelationManagers;
use App\Models\LecturerProfile;
use App\Models\Faculty;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LecturerResource extends Resource
{
    protected static ?string $model = LecturerProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $label = 'Lecturers';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Lecturer Information')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('User')
                            ->suffixAction(
                                Forms\Components\Actions\Action::make('create_user')
                                    ->icon('heroicon-o-plus')
                                    ->label('Create New User')
                                    ->modalHeading('Create New User')
                                    ->modalDescription('Create a new user account for this lecturer.')
                                    ->form([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->label('Full Name'),
                                        Forms\Components\TextInput::make('email')
                                            ->email()
                                            ->required()
                                            ->maxLength(255)
                                            ->unique('users', 'email')
                                            ->label('Email Address'),
                                        Forms\Components\TextInput::make('phone')
                                            ->tel()
                                            ->maxLength(20)
                                            ->label('Phone Number'),
                                        Forms\Components\TextInput::make('password')
                                            ->password()
                                            ->required()
                                            ->minLength(8)
                                            ->label('Password'),
                                    ])
                                    ->action(function (array $data) {
                                        // Create the user
                                        $user = User::create([
                                            'name' => $data['name'],
                                            'email' => $data['email'],
                                            'phone' => $data['phone'],
                                            'password' => bcrypt($data['password']),
                                            'is_active' => true,
                                        ]);

                                        // Assign lecturer user type
                                        /* $lecturerType = \App\Models\UserType::where('name', 'lecturer')->first();
                                        if ($lecturerType) {
                                            $user->assignUserType($lecturerType, null, true);
                                        } */

                                        return $user->id;
                                    })
                                    ->successNotification(
                                        \Filament\Notifications\Notification::make()
                                            ->success()
                                            ->title('User created successfully')
                                            ->body('The user has been created and assigned the lecturer type.')
                                    ),
                            ),
                        Forms\Components\TextInput::make('lecturer_id')
                            ->required()
                            ->maxLength(50)
                            ->unique(ignoreRecord: true)
                            ->label('Lecturer ID')
                            ->helperText('Auto-generated based on faculty and sequence.'),
                        Forms\Components\Select::make('faculty_id')
                            ->relationship('faculty', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Faculty')
                            ->reactive()
                            ->afterStateUpdated(function (Set $set, Get $get) {
                                $facultyId = $get('faculty_id');
                                if (!$facultyId) {
                                    return;
                                }
                                $generated = self::generateLecturerId($facultyId);
                                if ($generated) {
                                    $set('lecturer_id', $generated);
                                }
                            }),
                    ])->columns(2),

                Forms\Components\Section::make('Academic Information')
                    ->schema([
                        Forms\Components\TextInput::make('specialization')
                            ->maxLength(255)
                            ->label('Specialization'),
                        Forms\Components\Select::make('academic_rank')
                            ->options([
                                'assistant' => 'Assistant Lecturer',
                                'lecturer' => 'Lecturer',
                                'associate_professor' => 'Associate Professor',
                                'professor' => 'Professor',
                            ])
                            ->required()
                            ->default('lecturer')
                            ->label('Academic Rank'),
                        Forms\Components\Select::make('qualification')
                            ->options([
                                'PhD' => 'PhD',
                                'Master' => 'Master',
                                'Bachelor' => 'Bachelor',
                                'Diploma' => 'Diploma',
                            ])
                            ->label('Qualification'),
                        Forms\Components\Textarea::make('research_interests')
                            ->rows(3)
                            ->label('Research Interests')
                            ->placeholder('Enter research interests separated by commas'),
                    ])->columns(2),

                Forms\Components\Section::make('Contact Information')
                    ->schema([
                        Forms\Components\TextInput::make('office_location')
                            ->maxLength(255)
                            ->label('Office Location'),
                        Forms\Components\Textarea::make('office_hours')
                            ->rows(3)
                            ->label('Office Hours')
                            ->placeholder('e.g., Monday: 9:00 AM - 11:00 AM'),
                    ])->columns(2),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'retired' => 'Retired',
                            ])
                            ->required()
                            ->default('active')
                            ->label('Lecturer Status'),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('user.avatar_url')
                    ->circular()
                    ->defaultImageUrl(function ($record) {
                        return 'https://ui-avatars.com/api/?name=' . urlencode($record->user->name);
                    }),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Lecturer Name'),
                Tables\Columns\TextColumn::make('lecturer_id')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('faculty.name')
                    ->searchable()
                    ->sortable()
                    ->label('Faculty'),
                Tables\Columns\TextColumn::make('academic_rank')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'professor' => 'success',
                        'associate_professor' => 'info',
                        'lecturer' => 'warning',
                        'assistant' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'assistant' => 'Assistant',
                        'lecturer' => 'Lecturer',
                        'associate_professor' => 'Associate Prof.',
                        'professor' => 'Professor',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('specialization')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('qualification')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('office_location')
                    ->searchable()
                    ->limit(25)
                    ->label('Office'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'warning',
                        'retired' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'retired' => 'Retired',
                    ])
                    ->label('Status'),
                Tables\Filters\SelectFilter::make('academic_rank')
                    ->options([
                        'assistant' => 'Assistant Lecturer',
                        'lecturer' => 'Lecturer',
                        'associate_professor' => 'Associate Professor',
                        'professor' => 'Professor',
                    ])
                    ->label('Academic Rank'),
                Tables\Filters\SelectFilter::make('faculty_id')
                    ->relationship('faculty', 'name')
                    ->label('Faculty'),
                Tables\Filters\SelectFilter::make('qualification')
                    ->options([
                        'PhD' => 'PhD',
                        'Master' => 'Master',
                        'Bachelor' => 'Bachelor',
                        'Diploma' => 'Diploma',
                    ])
                    ->label('Qualification'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            // ->recordUrl(fn (LecturerProfile $record): string => LecturerResource::getUrl('view', ['record' => $record]))
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLecturers::route('/'),
            'create' => Pages\CreateLecturer::route('/create'),
            'edit' => Pages\EditLecturer::route('/{record}/edit'),
        ];
    }

    /**
     * Generate a lecturer ID using faculty code and a per-faculty sequence number.
     */
    private static function generateLecturerId(?int $facultyId): ?string
    {
        if (!$facultyId) {
            return null;
        }

        $faculty = Faculty::find($facultyId);
        $facultyCode = $faculty?->code ?: (string) $facultyId;

        $sequence = LecturerProfile::query()
            ->where('faculty_id', $facultyId)
            ->count() + 1;

        $sequencePadded = str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);

        return sprintf('%s-%s', strtoupper($facultyCode), $sequencePadded);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['user', 'faculty']);
    }
}
