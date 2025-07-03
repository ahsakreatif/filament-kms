<?php

namespace App\Enums;

enum Role: string
{
    case SUPER_ADMIN = 'super_admin';
    case LECTURER = 'lecturer';
    case ACADEMIC_STAFF = 'academic_staff';
    case STUDENT = 'student';

    // Set ID for each role
    public function id(): int
    {
        return match ($this) {
            self::SUPER_ADMIN => 1,
            self::LECTURER => 2,
            self::ACADEMIC_STAFF => 3,
            self::STUDENT => 4,
        };
    }

    public static function all(): array
    {
        return [
            self::SUPER_ADMIN->value,
            self::LECTURER->value,
            self::ACADEMIC_STAFF->value,
            self::STUDENT->value,
        ];
    }
}
