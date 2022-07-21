<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'user_id'
    ];

    /**
     * User of post
     * @return BelongsTo
     */
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Likes of post
     * @return BelongsToMany
     */
    public function Likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_post_like')
            ->withPivot('date');
    }

    /**
     * Comments of post
     * @return BelongsToMany
     */
    public function Comments(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_post_comment')
            ->withPivot('date', 'comment');
    }

}
