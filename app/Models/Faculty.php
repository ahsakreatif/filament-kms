<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    /**
     * The factory class for this model.
     */
    protected static $factory = \Database\Factories\FacultyFactory::class;
    protected $fillable = ['name', 'code', 'description', 'is_active'];

    public function studyPrograms()
    {
        return $this->hasMany(StudyProgram::class);
    }

    public function students()
    {
        return $this->hasMany(StudentProfile::class);
    }

    public function lecturers()
    {
        return $this->hasMany(LecturerProfile::class);
    }
}
