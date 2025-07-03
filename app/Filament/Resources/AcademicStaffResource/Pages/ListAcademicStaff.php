<?php

namespace App\Filament\Resources\AcademicStaffResource\Pages;

use App\Filament\Resources\AcademicStaffResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAcademicStaff extends ListRecords
{
    protected static string $resource = AcademicStaffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
