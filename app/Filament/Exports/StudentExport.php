<?php

namespace App\Filament\Exports;

use App\Models\StudentProfile;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class StudentExport extends Exporter
{
    protected static ?string $model = StudentProfile::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('user.name')
                ->label('Student Name'),
            ExportColumn::make('student_id')
                ->label('Student ID'),
            ExportColumn::make('studyProgram.code')
                ->label('Study Program Code'),
            ExportColumn::make('faculty.code')
                ->label('Faculty Code'),
            ExportColumn::make('enrollment_year')
                ->label('Enrollment Year'),
            ExportColumn::make('current_semester')
                ->label('Current Semester'),
            ExportColumn::make('gpa')
                ->label('GPA'),
            ExportColumn::make('advisor.name')
                ->label('Academic Advisor'),
            ExportColumn::make('status')
                ->label('Status'),
            ExportColumn::make('user.email')
                ->label('Email'),
            ExportColumn::make('user.phone')
                ->label('Phone'),
            ExportColumn::make('created_at')
                ->label('Created At'),
            ExportColumn::make('updated_at')
                ->label('Updated At'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your student export has completed and is ready to download.';

        if ($export->successful_rows > 0) {
            $body .= " {$export->successful_rows} students exported successfully.";
        }

        if ($export->failed_rows > 0) {
            $body .= " {$export->failed_rows} students failed to export.";
        }

        return $body;
    }
}
