<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Kirschbaum\Commentions\Contracts\Commenter;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasPermissions;

class User extends Authenticatable implements Commenter, HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar_url',
        'is_active',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the student profile associated with the user.
     */
    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    /**
     * Get the lecturer profile associated with the user.
     */
    public function lecturerProfile()
    {
        return $this->hasOne(LecturerProfile::class);
    }

    /**
     * Get the academic staff profile associated with the user.
     */
    public function academicStaffProfile()
    {
        return $this->hasOne(AcademicStaffProfile::class);
    }

    /**
     * Get the user types associated with the user.
     */
    public function userTypes()
    {
        return $this->belongsToMany(UserType::class, 'user_type_assignments')
            ->withPivot(['profile_id', 'is_primary', 'assigned_at', 'assigned_by'])
            ->withTimestamps();
    }

    /**
     * Get the primary user type for this user.
     */
    public function getPrimaryTypeAttribute()
    {
        return $this->userTypes()->wherePivot('is_primary', true)->first();
    }

    /**
     * Check if user has a specific user type.
     */
    public function hasUserType($typeName)
    {
        return $this->userTypes()->where('name', $typeName)->exists();
    }

    /**
     * Get the primary profile for this user.
     */
    public function getPrimaryProfileAttribute()
    {
        $primaryType = $this->primaryType;

        if (!$primaryType) {
            return null;
        }

        switch ($primaryType->name) {
            case 'student':
                return $this->studentProfile;
            case 'lecturer':
                return $this->lecturerProfile;
            case 'academic_staff':
                return $this->academicStaffProfile;
            default:
                return null;
        }
    }

    /**
     * Get user's institutional ID based on primary type.
     */
    public function getInstitutionalIdAttribute()
    {
        $profile = $this->primaryProfile;

        if (!$profile) {
            return null;
        }

        switch ($this->primaryType->name) {
            case 'student':
                return $profile->student_id;
            case 'lecturer':
                return $profile->lecturer_id;
            case 'academic_staff':
                return $profile->academic_id;
            default:
                return null;
        }
    }

    /**
     * Sync roles based on user types.
     */
    public function syncRolesFromUserTypes()
    {
        // Remove all existing roles first
        $this->syncRoles([]);

        // Assign roles based on user types
        foreach ($this->userTypes as $userType) {
            if ($userType->role_name) {
                $this->assignRole($userType->role_name);
            }
        }
    }

    /**
     * Assign a user type and automatically assign the corresponding role.
     */
    public function assignUserType(UserType $userType, $profileId = null, $isPrimary = false, $assignedBy = null)
    {
        // Create the user type assignment
        $this->userTypes()->attach($userType->id, [
            'profile_id' => $profileId,
            'is_primary' => $isPrimary,
            'assigned_at' => now(),
            'assigned_by' => $assignedBy,
        ]);

        // Assign the corresponding role
        $userType->assignRoleToUser($this);

        // Auto-create profile if it doesn't exist and user type requires one
        if ($userType->name === 'student' && !$this->studentProfile) {
            $this->studentProfile()->create([
                'student_id' => 'STU' . str_pad($this->id, 6, '0', STR_PAD_LEFT),
                'status' => 'active',
            ]);
        }
    }

    /**
     * Remove a user type and automatically remove the corresponding role.
     */
    public function removeUserType(UserType $userType)
    {
        // Remove the user type assignment
        $this->userTypes()->detach($userType->id);

        // Remove the corresponding role
        $userType->removeRoleFromUser($this);
    }

    /**
     * Get the user's tag preferences for recommendations.
     */
    public function tagPreferences()
    {
        return $this->hasMany(UserTagPreference::class);
    }

    /**
     * Get the user's forum threads.
     */
    public function forumThreads()
    {
        return $this->hasMany(ForumThread::class);
    }

    /**
     * Get the user's forum thread likes.
     */
    public function forumThreadLikes()
    {
        return $this->hasMany(ForumThreadLike::class);
    }

    /**
     * Get the user's forum thread views.
     */
    public function forumThreadViews()
    {
        return $this->hasMany(ForumThreadView::class);
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url($this->avatar_url) : null;
    }
}
