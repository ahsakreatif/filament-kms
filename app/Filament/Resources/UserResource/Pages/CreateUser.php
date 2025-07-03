<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\UserType;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterCreate(): void
    {
        $record = $this->record;
        $data = $this->data;

        // Handle student profile creation if student type is assigned
        if (isset($data['user_types']) && is_array($data['user_types'])) {
            $hasStudentType = collect($data['user_types'])->contains(function ($userTypeId) {
                $userType = UserType::find($userTypeId);
                return $userType && $userType->name === 'student';
            });

            if ($hasStudentType) {
                $record->studentProfile()->create([
                    'student_id' => 'STU' . str_pad($record->id, 6, '0', STR_PAD_LEFT),
                    'status' => 'active',
                ]);
            }
        }
    }
}
