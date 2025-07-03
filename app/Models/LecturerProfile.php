<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LecturerProfile extends Model
{
    use HasFactory;

    /**
     * The factory class for this model.
     */
    protected static $factory = \Database\Factories\LecturerProfileFactory::class;

    protected $fillable = [
        'user_id',
        'lecturer_id',
        'faculty_id',
        'specialization',
        'academic_rank',
        'qualification',
        'research_interests',
        'office_location',
        'office_hours',
        'status',
    ];

    protected $casts = [
        'research_interests' => 'array',
    ];

    /**
     * Get the user that owns this profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the faculty that this lecturer belongs to.
     */
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    /**
     * Get the students advised by this lecturer.
     */
    public function advisedStudents()
    {
        return $this->hasMany(StudentProfile::class, 'advisor_id');
    }

    /**
     * Scope to get only active lecturers.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get lecturers by faculty.
     */
    public function scopeByFaculty($query, $facultyId)
    {
        return $query->where('faculty_id', $facultyId);
    }

    /**
     * Scope to get lecturers by academic rank.
     */
    public function scopeByAcademicRank($query, $rank)
    {
        return $query->where('academic_rank', $rank);
    }
}
