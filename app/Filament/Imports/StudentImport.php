<?php

namespace App\Filament\Imports;

use App\Models\StudentProfile;
use App\Models\Faculty;
use App\Models\StudyProgram;
use App\Models\User;
use App\Models\UserType;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Facades\Hash;

class StudentImport extends Importer
{
    protected static ?string $model = StudentProfile::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('user_name')
                ->label('Student Name')
                ->rules(['required', 'string', 'max:255']),
            ImportColumn::make('user_email')
                ->label('Email')
                ->rules(['required', 'email', 'unique:users,email']),
            ImportColumn::make('user_phone')
                ->label('Phone')
                ->rules(['nullable', 'string', 'max:20']),
            ImportColumn::make('student_id')
                ->label('Student ID')
                ->rules(['required', 'string', 'max:50', 'unique:student_profiles,student_id']),
            ImportColumn::make('study_program_code')
                ->label('Study Program Code')
                ->rules(['required', 'exists:study_programs,code']),
            ImportColumn::make('faculty_code')
                ->label('Faculty Code')
                ->rules(['required', 'exists:faculties,code']),
            ImportColumn::make('enrollment_year')
                ->label('Enrollment Year')
                ->rules(['required', 'integer', 'min:2000', 'max:2030']),
            ImportColumn::make('current_semester')
                ->label('Current Semester')
                ->rules(['required', 'integer', 'min:1', 'max:14']),
            ImportColumn::make('gpa')
                ->label('GPA')
                ->rules(['nullable', 'numeric', 'min:0', 'max:4']),
            ImportColumn::make('advisor_email')
                ->label('Advisor Email')
                ->rules(['nullable', 'email', 'exists:users,email']),
            ImportColumn::make('status')
                ->label('Status')
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
                ->label('Student Name'),
            ImportColumn::make('user_email')
                ->label('Email'),
            ImportColumn::make('user_phone')
                ->label('Phone'),
            ImportColumn::make('student_id')
                ->label('Student ID'),
            ImportColumn::make('study_program_code')
                ->label('Study Program Code'),
            ImportColumn::make('faculty_code')
                ->label('Faculty Code'),
            ImportColumn::make('enrollment_year')
                ->label('Enrollment Year'),
            ImportColumn::make('current_semester')
                ->label('Current Semester'),
            ImportColumn::make('gpa')
                ->label('GPA'),
            ImportColumn::make('advisor_email')
                ->label('Advisor Email'),
            ImportColumn::make('status')
                ->label('Status')
                ->options([
                    'active' => 'Active',
                    'graduated' => 'Graduated',
                    'suspended' => 'Suspended',
                    'dropped' => 'Dropped',
                ]),
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        return 'Student import completed.';
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

        // Map faculty and study program by code to their IDs
        if (!empty($this->data['faculty_code'])) {
            $faculty = Faculty::where('code', $this->data['faculty_code'])->first();
            if ($faculty) {
                $this->record->faculty_id = $faculty->id;

                if (!empty($this->data['study_program_code'])) {
                    $program = StudyProgram::where('code', $this->data['study_program_code'])
                        ->where('faculty_id', $faculty->id)
                        ->first();
                    if ($program) {
                        $this->record->study_program_id = $program->id;
                    }
                }
            }
        }

        // Set advisor if provided
        if (!empty($this->data['advisor_email'])) {
            $advisor = User::where('email', $this->data['advisor_email'])->first();
            if ($advisor) {
                $this->record->advisor_id = $advisor->id;
            }
        }
    }
}
