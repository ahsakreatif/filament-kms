<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StudyProgram;
use App\Models\Faculty;

class StudentProfile extends Model
{
    use HasFactory;

    /**
     * The factory class for this model.
     */
    protected static $factory = \Database\Factories\StudentProfileFactory::class;

    protected $fillable = [
        'user_id',
        'student_id',
        'study_program_id',
        'faculty_id',
        'enrollment_year',
        'current_semester',
        'gpa',
        'advisor_id',
        'status',
    ];

    protected $casts = [
        'gpa' => 'decimal:2',
        'enrollment_year' => 'integer',
        'current_semester' => 'integer',
    ];

    /**
     * Get the user that owns this profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the advisor (lecturer) for this student.
     */
    public function advisor()
    {
        return $this->belongsTo(LecturerProfile::class, 'advisor_id');
    }

    /**
     * Get the study program for this student.
     */
    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class, 'study_program_id');
    }

    /**
     * Get the faculty for this student.
     */
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }
    /**
     * Get the students advised by this lecturer.
     */
    public function advisedStudents()
    {
        return $this->hasMany(StudentProfile::class, 'advisor_id');
    }

    /**
     * Scope to get only active students.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get students by faculty.
     */
    public function scopeByFaculty($query, $facultyId)
    {
        return $query->where('faculty_id', $facultyId);
    }

    /**
     * Scope to get students by study program.
     */
    public function scopeByStudyProgram($query, $studyProgramId)
    {
        return $query->where('study_program_id', $studyProgramId);
    }
}
