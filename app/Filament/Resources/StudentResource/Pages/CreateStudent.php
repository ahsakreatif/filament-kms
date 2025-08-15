<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Enums\Role;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected function afterCreate(): void
    {
        $studentType = \App\Models\UserType::where('name', Role::STUDENT->value)->first();
        $this->record->user->assignUserType($studentType, $this->record->id, true);
    }
}
