<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
        'avatar',
        'old_passwords',
        'password_changed_at',
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
            'old_passwords' => 'array',
            'password_changed_at' => 'datetime',
        ];
    }
    
    /**
     * Get the user's avatar URL or default image.
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar && file_exists(public_path('storage/avatars/' . $this->avatar))) {
            return asset('storage/avatars/' . $this->avatar);
        }
        
        return asset('images/user.png');
    }

    /**
     * Fields to exclude from auditing
     */
    protected $auditExclude = [
        'password',
        'remember_token',
        'email_verified_at',
        'updated_at',
        'created_at'
    ];

    /**
     * Add current password to old passwords history
     */
    public function addToPasswordHistory($currentPassword)
    {
        $oldPasswords = $this->old_passwords ?? [];
        
        // Add current password to history
        $oldPasswords[] = [
            'password' => $currentPassword,
            'changed_at' => now()->toISOString(),
        ];
        
        // Keep only last 5 passwords
        if (count($oldPasswords) > 5) {
            $oldPasswords = array_slice($oldPasswords, -5);
        }
        
        $this->old_passwords = $oldPasswords;
        $this->password_changed_at = now();
    }

    /**
     * Check if password was used before
     */
    public function isPasswordInHistory($password)
    {
        if (!$this->old_passwords) {
            return false;
        }
        
        foreach ($this->old_passwords as $oldPassword) {
            if (Hash::check($password, $oldPassword['password'])) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Get password history with timestamps
     */
    public function getPasswordHistory()
    {
        return $this->old_passwords ?? [];
    }
}
