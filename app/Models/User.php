<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mastodon',
        'sendegate',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
        'avatar',
        'avatar_tiny',
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
        ];
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function hasRole($role)
    {
        return in_array($role, $this->roles->pluck('name')->toArray());
    }

    protected function defaultProfilePhotoUrl()
    {
        return '/avatar.png';
    }

    public function getAvatarTinyAttribute()
    {
        $path = explode('/', $this->profile_photo_url);
        if (count($path) > 2) {
            return '/storage/tiny/logos/'.$path[array_key_last($path)];
        }

        return '/avatar.png';
    }

    public function getAvatarAttribute()
    {
        $path = explode('/', $this->profile_photo_url);
        if (count($path) > 2) {
            return '/storage/big/logos/'.$path[array_key_last($path)];
        }

        return '/avatar.png';
    }
}
