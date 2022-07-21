<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Posts of user
     * @return HasMany
     */
    public function Posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }


    /**
     * Likes of post
     * @return BelongsToMany
     */
    public function Likes(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'user_post_like');
    }

    /**
     * Comments of post
     * @return BelongsToMany
     */
    public function Comments(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'user_post_comment');
    }

    /**
     * @param $token
     * @return array
     */
    public function responseWithToken($token): array
    {
        return [
            'status'    => true,
            'timestamp' => now(),
            'token'     => $token
        ];
    }

}
