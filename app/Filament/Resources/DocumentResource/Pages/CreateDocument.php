<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
use Filament\Facades\Filament;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set uploaded_by to current user
        $data['uploaded_by'] = Filament::auth()->id();

        // Generate slug from title if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Extract file metadata if file is uploaded
        if (isset($data['file_path']) && is_array($data['file_path'])) {
            $filePath = $data['file_path'][0] ?? null;
            if ($filePath) {
                $fullPath = storage_path('app/public/' . $filePath);
                if (file_exists($fullPath)) {
                    $data['file_name'] = basename($filePath);
                    $data['file_size'] = filesize($fullPath);
                    $data['file_type'] = pathinfo($filePath, PATHINFO_EXTENSION);
                    $data['mime_type'] = mime_content_type($fullPath);
                }
            }
        }

        return $data;
    }
}
