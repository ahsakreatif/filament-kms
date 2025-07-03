<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTypeAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_type_id',
        'profile_id',
        'is_primary',
        'assigned_at',
        'assigned_by',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'assigned_at' => 'datetime',
    ];

    /**
     * Get the user that owns this assignment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user type for this assignment.
     */
    public function userType()
    {
        return $this->belongsTo(UserType::class);
    }

    /**
     * Get the user who assigned this type.
     */
    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    /**
     * Scope to get only primary assignments.
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }
}
