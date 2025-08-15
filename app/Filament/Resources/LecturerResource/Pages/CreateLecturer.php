<?php

namespace App\Filament\Resources\LecturerResource\Pages;

use App\Filament\Resources\LecturerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Enums\Role;

class CreateLecturer extends CreateRecord
{
    protected static string $resource = LecturerResource::class;

    protected function afterCreate(): void
    {
        $lecturerType = \App\Models\UserType::where('name', Role::LECTURER->value)->first();
        $this->record->user->assignUserType($lecturerType, $this->record->id, true);
    }
}
