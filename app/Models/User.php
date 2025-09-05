<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'slug',
        'bio'
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
        ];
    }

    public function articles()
    {
        return $this->hasMany(\App\Models\Article::class);
    }

    public function favoriteLists()
    {
        return $this->hasMany(FavoriteList::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->slug)) {
                $user->slug = Str::slug($user->name) . '-' . uniqid();
            }
        });

        static::updating(function ($user) {
            if ($user->isDirty('name')) {
                $user->slug = Str::slug($user->name) . '-' . uniqid();
            }
        });
    }
}
