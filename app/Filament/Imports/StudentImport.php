<?php

namespace App\Filament\Imports;

use App\Models\StudentProfile;
use App\Models\User;
use App\Models\UserType;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Illuminate\Support\Facades\Hash;

class StudentImport extends Importer
{
    protected static ?string $model = StudentProfile::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('user_name')
                ->label('Student Name')
                ->required()
                ->rules(['required', 'string', 'max:255']),
            ImportColumn::make('user_email')
                ->label('Email')
                ->required()
                ->rules(['required', 'email', 'unique:users,email'])
                ->unique(ignoreRecord: true),
            ImportColumn::make('user_phone')
                ->label('Phone')
                ->rules(['nullable', 'string', 'max:20']),
            ImportColumn::make('student_id')
                ->label('Student ID')
                ->required()
                ->rules(['required', 'string', 'max:50', 'unique:student_profiles,student_id'])
                ->unique(ignoreRecord: true),
            ImportColumn::make('study_program')
                ->label('Study Program')
                ->required()
                ->rules(['required', 'string', 'max:255']),
            ImportColumn::make('faculty')
                ->label('Faculty')
                ->required()
                ->rules(['required', 'string', 'max:255']),
            ImportColumn::make('enrollment_year')
                ->label('Enrollment Year')
                ->required()
                ->rules(['required', 'integer', 'min:2000', 'max:2030']),
            ImportColumn::make('current_semester')
                ->label('Current Semester')
                ->required()
                ->rules(['required', 'integer', 'min:1', 'max:14']),
            ImportColumn::make('gpa')
                ->label('GPA')
                ->rules(['nullable', 'numeric', 'min:0', 'max:4']),
            ImportColumn::make('advisor_email')
                ->label('Advisor Email')
                ->rules(['nullable', 'email', 'exists:users,email']),
            ImportColumn::make('status')
                ->label('Status')
                ->required()
                ->rules(['required', 'in:active,graduated,suspended,dropped'])
                ->options([
                    'active' => 'Active',
                    'graduated' => 'Graduated',
                    'suspended' => 'Suspended',
                    'dropped' => 'Dropped',
                ]),
        ];
    }

    public static function getTemplateColumns(): array
    {
        return [
            ImportColumn::make('user_name')
                ->label('Student Name')
                ->required(),
            ImportColumn::make('user_email')
                ->label('Email')
                ->required(),
            ImportColumn::make('user_phone')
                ->label('Phone'),
            ImportColumn::make('student_id')
                ->label('Student ID')
                ->required(),
            ImportColumn::make('study_program')
                ->label('Study Program')
                ->required(),
            ImportColumn::make('faculty')
                ->label('Faculty')
                ->required(),
            ImportColumn::make('enrollment_year')
                ->label('Enrollment Year')
                ->required(),
            ImportColumn::make('current_semester')
                ->label('Current Semester')
                ->required(),
            ImportColumn::make('gpa')
                ->label('GPA'),
            ImportColumn::make('advisor_email')
                ->label('Advisor Email'),
            ImportColumn::make('status')
                ->label('Status')
                ->required()
                ->options([
                    'active' => 'Active',
                    'graduated' => 'Graduated',
                    'suspended' => 'Suspended',
                    'dropped' => 'Dropped',
                ]),
        ];
    }

    public function resolveRecord(): ?StudentProfile
    {
        // Try to find existing student profile by student_id
        return StudentProfile::where('student_id', $this->data['student_id'])->first();
    }

    public function resolveRecordUsing(array $data): ?StudentProfile
    {
        return StudentProfile::where('student_id', $data['student_id'])->first();
    }

    public function beforeSave(): void
    {
        // Create or find user
        $user = User::where('email', $this->data['user_email'])->first();

        if (!$user) {
            $user = User::create([
                'name' => $this->data['user_name'],
                'email' => $this->data['user_email'],
                'phone' => $this->data['user_phone'] ?? null,
                'password' => Hash::make('password123'), // Default password
                'is_active' => true,
            ]);

            // Assign student user type
            $studentType = UserType::where('name', 'student')->first();
            if ($studentType) {
                $user->assignUserType($studentType, null, true);
            }
        }

        // Set the user_id for the student profile
        $this->record->user_id = $user->id;

        // Set advisor if provided
        if (!empty($this->data['advisor_email'])) {
            $advisor = User::where('email', $this->data['advisor_email'])->first();
            if ($advisor) {
                $this->record->advisor_id = $advisor->id;
            }
        }
    }
}
