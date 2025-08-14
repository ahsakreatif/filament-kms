<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AcademicStaffResource\Pages;
use App\Filament\Resources\AcademicStaffResource\RelationManagers;
use App\Models\AcademicStaffProfile;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AcademicStaffResource extends Resource
{
    protected static ?string $model = AcademicStaffProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $label = 'Academic Staff';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Academic Staff Information')
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
                                    ->modalDescription('Create a new user account for this academic staff.')
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

                                        // Assign academic staff user type
                                        $academicStaffType = \App\Models\UserType::where('name', 'academic_staff')->first();
                                        if ($academicStaffType) {
                                            $user->assignUserType($academicStaffType, null, true);
                                        }

                                        return $user->id;
                                    })
                                    ->successNotification(
                                        \Filament\Notifications\Notification::make()
                                            ->success()
                                            ->title('User created successfully')
                                            ->body('The user has been created and assigned the academic staff type.')
                                    ),
                            ),
                        Forms\Components\TextInput::make('academic_id')
                            ->required()
                            ->maxLength(50)
                            ->unique(ignoreRecord: true)
                            ->label('Academic ID'),
                        Forms\Components\Select::make('faculty_id')
                            ->relationship('faculty', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Faculty'),
                    ])->columns(2),

                Forms\Components\Section::make('Position & Responsibilities')
                    ->schema([
                        Forms\Components\Select::make('position')
                            ->options([
                                'administrative_officer' => 'Administrative Officer',
                                'senior_administrative_officer' => 'Senior Administrative Officer',
                                'principal_administrative_officer' => 'Principal Administrative Officer',
                                'assistant_registrar' => 'Assistant Registrar',
                                'deputy_registrar' => 'Deputy Registrar',
                                'registrar' => 'Registrar',
                                'librarian' => 'Librarian',
                                'assistant_librarian' => 'Assistant Librarian',
                                'senior_librarian' => 'Senior Librarian',
                                'technician' => 'Technician',
                                'senior_technician' => 'Senior Technician',
                                'chief_technician' => 'Chief Technician',
                                'other' => 'Other',
                            ])
                            ->required()
                            ->searchable()
                            ->label('Position'),
                        Forms\Components\Textarea::make('responsibilities')
                            ->rows(4)
                            ->label('Responsibilities')
                            ->placeholder('Enter key responsibilities (one per line)')
                            ->helperText('Enter each responsibility on a new line'),
                    ])->columns(2),

                Forms\Components\Section::make('Contact Information')
                    ->schema([
                        Forms\Components\TextInput::make('office_location')
                            ->maxLength(255)
                            ->label('Office Location')
                            ->placeholder('e.g., Room 101, Administration Building'),
                    ])->columns(1),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'retired' => 'Retired',
                                'on_leave' => 'On Leave',
                            ])
                            ->required()
                            ->default('active')
                            ->label('Staff Status'),
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
                    ->label('Staff Name')
                    ->url(fn (AcademicStaffProfile $record): string =>
                        UserResource::getUrl('edit', ['record' => $record->user])),
                Tables\Columns\TextColumn::make('academic_id')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('faculty.name')
                    ->searchable()
                    ->sortable()
                    ->label('Faculty'),
                Tables\Columns\TextColumn::make('position')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'registrar', 'deputy_registrar' => 'success',
                        'assistant_registrar', 'principal_administrative_officer' => 'info',
                        'senior_administrative_officer', 'senior_librarian' => 'warning',
                        'administrative_officer', 'librarian', 'assistant_librarian' => 'gray',
                        'chief_technician' => 'success',
                        'senior_technician' => 'info',
                        'technician' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'administrative_officer' => 'Admin Officer',
                        'senior_administrative_officer' => 'Senior Admin Officer',
                        'principal_administrative_officer' => 'Principal Admin Officer',
                        'assistant_registrar' => 'Assistant Registrar',
                        'deputy_registrar' => 'Deputy Registrar',
                        'registrar' => 'Registrar',
                        'librarian' => 'Librarian',
                        'assistant_librarian' => 'Assistant Librarian',
                        'senior_librarian' => 'Senior Librarian',
                        'technician' => 'Technician',
                        'senior_technician' => 'Senior Technician',
                        'chief_technician' => 'Chief Technician',
                        default => ucwords(str_replace('_', ' ', $state)),
                    }),
                Tables\Columns\TextColumn::make('office_location')
                    ->searchable()
                    ->limit(25)
                    ->label('Office'),
                Tables\Columns\TextColumn::make('responsibilities')
                    ->listWithLineBreaks()
                    ->label('Responsibilities'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'warning',
                        'retired' => 'danger',
                        'on_leave' => 'info',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'retired' => 'Retired',
                        'on_leave' => 'On Leave',
                    ])
                    ->label('Status'),
                Tables\Filters\SelectFilter::make('position')
                    ->options([
                        'administrative_officer' => 'Administrative Officer',
                        'senior_administrative_officer' => 'Senior Administrative Officer',
                        'principal_administrative_officer' => 'Principal Administrative Officer',
                        'assistant_registrar' => 'Assistant Registrar',
                        'deputy_registrar' => 'Deputy Registrar',
                        'registrar' => 'Registrar',
                        'librarian' => 'Librarian',
                        'assistant_librarian' => 'Assistant Librarian',
                        'senior_librarian' => 'Senior Librarian',
                        'technician' => 'Technician',
                        'senior_technician' => 'Senior Technician',
                        'chief_technician' => 'Chief Technician',
                        'other' => 'Other',
                    ])
                    ->label('Position'),
                Tables\Filters\SelectFilter::make('faculty_id')
                    ->relationship('faculty', 'name')
                    ->label('Faculty'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            // ->recordUrl(fn (AcademicStaffProfile $record): string => AcademicStaffResource::getUrl('view', ['record' => $record]))
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
            'index' => Pages\ListAcademicStaff::route('/'),
            'create' => Pages\CreateAcademicStaff::route('/create'),
            'edit' => Pages\EditAcademicStaff::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['user', 'faculty']);
    }
}
