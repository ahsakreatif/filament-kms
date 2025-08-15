<?php

namespace App\Filament\Resources\AcademicStaffResource\Pages;

use App\Filament\Resources\AcademicStaffResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Enums\Role;

class CreateAcademicStaff extends CreateRecord
{
    protected static string $resource = AcademicStaffResource::class;

    protected function afterCreate(): void
    {
        $academicStaffType = \App\Models\UserType::where('name', Role::ACADEMIC_STAFF->value)->first();
        $this->record->user->assignUserType($academicStaffType, $this->record->id, true);
    }
}
