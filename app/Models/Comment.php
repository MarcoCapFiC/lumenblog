<?php

namespace App\Models;

use App\Http\Traits\UserTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Lumen\Auth\Authorizable;

class Comment extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory, UserTrait;

    protected $primaryKey = 'id';
    protected $fillable = [
        'post_id', 'content'
    ];
    protected $hidden = ['id'];
    protected $table = 'Comment';
    protected $withCount = ['likes'];

    protected $appends = ['auth_user_liked_comment'];

    public function getAuthUserLikedCommentAttribute(): bool
    {
        return $this->likes()->where('user_id', auth()->id())->exists();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
