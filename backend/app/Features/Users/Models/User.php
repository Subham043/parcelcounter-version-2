<?php

namespace App\Features\Users\Models;

use App\Features\Authentication\Notifications\RegisterOtpNotification;
use App\Features\Authentication\Notifications\ResetPasswordNotification;
use App\Features\Authentication\Notifications\VerifyEmailNotification;
use App\Features\Authentication\Services\AuthCache;
use App\Features\Roles\Interfaces\RoleTraitInterface;
use App\Features\Roles\Traits\RoleTrait;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Database\Factories\UserFactory;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, RoleTraitInterface
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, RoleTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'is_blocked',
        'email_verified_at',
        'phone_verified_at',
        'password',
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

    protected $appends = ['current_role'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_blocked' => 'boolean',
        ];
    }

    /**
     * User Factory.
     *
     */
    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function routeNotificationForSms(): string
    {
        return '91' . $this->phone;
    }

    protected static function booted()
    {
        parent::boot();
        static::updated(function ($user) {
            AuthCache::forget($user->id);
        });

        static::deleted(function ($user) {
            AuthCache::forget($user->id);
        });

        static::saved(function ($user) {
            AuthCache::forget($user->id);
        });
    }
}
