<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'profile_table',
        'role_name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the users that have this user type.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_type_assignments')
            ->withPivot(['profile_id', 'is_primary', 'assigned_at', 'assigned_by'])
            ->withTimestamps();
    }

    /**
     * Get the user type assignments for this type.
     */
    public function assignments()
    {
        return $this->hasMany(UserTypeAssignment::class);
    }

    /**
     * Get the corresponding Spatie role for this user type.
     */
    public function getSpatieRoleAttribute()
    {
        if (!$this->role_name) {
            return null;
        }

        return \Spatie\Permission\Models\Role::where('name', $this->role_name)->first();
    }

    /**
     * Assign the corresponding role to a user.
     */
    public function assignRoleToUser(User $user)
    {
        if ($this->role_name) {
            $user->assignRole($this->role_name);
        }
    }

    /**
     * Remove the corresponding role from a user.
     */
    public function removeRoleFromUser(User $user)
    {
        if ($this->role_name) {
            $user->removeRole($this->role_name);
        }
    }

    /**
     * Scope to get only active user types.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
