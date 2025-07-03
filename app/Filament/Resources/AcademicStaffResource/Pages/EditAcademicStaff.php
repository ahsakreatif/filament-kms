<?php

namespace App\Filament\Resources\AcademicStaffResource\Pages;

use App\Filament\Resources\AcademicStaffResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAcademicStaff extends EditRecord
{
    protected static string $resource = AcademicStaffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
