<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\StudentProfile;
use App\Models\Faculty;
use App\Models\User;
use App\Filament\Exports\StudentExport;
use App\Filament\Imports\StudentImport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = StudentProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $label = 'Students';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Student Information')
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
                                    ->modalDescription('Create a new user account for this student.')
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

                                        // Assign student user type
                                        $studentType = \App\Models\UserType::where('name', 'student')->first();
                                        if ($studentType) {
                                            $user->assignUserType($studentType, null, true);
                                        }

                                        return $user->id;
                                    })
                                    ->successNotification(
                                        \Filament\Notifications\Notification::make()
                                            ->success()
                                            ->title('User created successfully')
                                            ->body('The user has been created and assigned the student type.')
                                    ),
                            ),
                        Forms\Components\TextInput::make('student_id')
                            ->required()
                            ->maxLength(50)
                            ->unique(ignoreRecord: true)
                            ->label('Student ID'),
                        Forms\Components\TextInput::make('study_program')
                            ->required()
                            ->maxLength(255)
                            ->label('Study Program'),
                        Forms\Components\Select::make('faculty')
                            ->relationship('faculty', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Faculty'),
                    ])->columns(2),

                Forms\Components\Section::make('Academic Information')
                    ->schema([
                        Forms\Components\TextInput::make('enrollment_year')
                            ->required()
                            ->numeric()
                            ->minValue(2000)
                            ->maxValue(2030)
                            ->label('Enrollment Year'),
                        Forms\Components\TextInput::make('current_semester')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(14)
                            ->label('Current Semester'),
                        Forms\Components\TextInput::make('gpa')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(4)
                            ->step(0.01)
                            ->label('GPA'),
                        Forms\Components\Select::make('advisor_id')
                            ->relationship('advisor', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Academic Advisor')
                            ->placeholder('Select an advisor')
                            ->options(function () {
                                return User::whereHas('userTypes', function ($query) {
                                    $query->where('name', 'lecturer');
                                })->pluck('name', 'id');
                            }),
                    ])->columns(2),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'graduated' => 'Graduated',
                                'suspended' => 'Suspended',
                                'dropped' => 'Dropped',
                            ])
                            ->required()
                            ->default('active')
                            ->label('Student Status'),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Student Name'),
                Tables\Columns\TextColumn::make('student_id')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('study_program.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('faculty.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('current_semester')
                    ->sortable()
                    ->label('Semester'),
                Tables\Columns\TextColumn::make('gpa')
                    ->numeric(
                        decimalPlaces: 2,
                        decimalSeparator: '.',
                        thousandsSeparator: ',',
                    )
                    ->sortable(),
                Tables\Columns\TextColumn::make('advisor.name')
                    ->label('Advisor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'suspended' => 'warning',
                        'dropped' => 'danger',
                        'graduated' => 'info',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'graduated' => 'Graduated',
                        'suspended' => 'Suspended',
                        'dropped' => 'Dropped',
                    ])
                    ->label('Status'),
                Tables\Filters\SelectFilter::make('faculty')
                    ->options(fn () => Faculty::all()->pluck('name', 'id'))
                    ->label('Faculty'),
            ])
            ->headerActions([
                Tables\Actions\ImportAction::make()
                    ->importer(StudentImport::class)
                    ->label('Import Students')
                    ->icon('heroicon-o-arrow-up-tray'),
                Tables\Actions\ExportAction::make()
                    ->exporter(StudentExport::class)
                    ->label('Export Students')
                    ->icon('heroicon-o-arrow-down-tray'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'view' => Pages\ViewStudent::route('/{record}'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['user', 'advisor']);
    }
}
