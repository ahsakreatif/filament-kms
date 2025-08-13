<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentProfileRelationManager extends RelationManager
{
    protected static string $relationship = 'studentProfile';

    protected static ?string $title = 'Student Profile';

    public static function canViewForRecord($record, string $pageClass): bool
    {
        return $record->hasUserType('student');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Student Information')
                    ->schema([
                        Forms\Components\TextInput::make('student_id')
                            ->required()
                            ->maxLength(50)
                            ->unique(ignoreRecord: true)
                            ->label('Student ID'),
                        Forms\Components\TextInput::make('study_program')
                            ->required()
                            ->maxLength(255)
                            ->label('Study Program'),
                        Forms\Components\Select::make('faculty_id')
                            ->relationship('faculty', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
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
                                return \App\Models\User::whereHas('userTypes', function ($query) {
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('student_id')
            ->columns([
                Tables\Columns\TextColumn::make('student_id')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('study_program')
                    ->sortable(),
                Tables\Columns\TextColumn::make('faculty.name')
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
                Tables\Filters\SelectFilter::make('faculty_id')
                    ->options(fn () => \App\Models\Faculty::pluck('name', 'id'))
                    ->label('Faculty'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
