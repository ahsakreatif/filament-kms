<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicStaffProfile extends Model
{
    use HasFactory;

    /**
     * The factory class for this model.
     */
    protected static $factory = \Database\Factories\AcademicStaffProfileFactory::class;

    protected $fillable = [
        'user_id',
        'academic_id',
        'faculty_id',
        'position',
        'office_location',
        'responsibilities',
        'status',
    ];

    protected $casts = [
        'responsibilities' => 'array',
    ];

    /**
     * Get the user that owns this profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the faculty that this academic staff belongs to.
     */
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    /**
     * Scope to get only active academic staff.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get academic staff by faculty.
     */
    public function scopeByFaculty($query, $facultyId)
    {
        return $query->where('faculty_id', $facultyId);
    }

    /**
     * Scope to get academic staff by position.
     */
    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position);
    }
}
