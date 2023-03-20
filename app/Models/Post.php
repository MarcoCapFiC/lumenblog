<?php

namespace App\Models;

use App\Http\Traits\UserTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Auth\Authorizable;

/**
 *
 */
class Post extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory, UserTrait;

    protected $primaryKey = 'id';
    protected $fillable = [
        'title', 'content'
    ];
    protected $hidden = [];
    protected $table = 'Post';
    public $timestamps = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
