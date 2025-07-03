<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    /**
     * The factory class for this model.
     */
    protected static $factory = \Database\Factories\StudyProgramFactory::class;
    protected $fillable = ['name', 'code', 'faculty_id', 'description', 'degree_level', 'duration_years', 'is_active'];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function students()
    {
        return $this->hasMany(StudentProfile::class);
    }
}
