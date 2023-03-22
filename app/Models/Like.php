<?php

namespace App\Models;

use App\Http\Traits\UserTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Laravel\Lumen\Auth\Authorizable;

class Like extends Model
{
    use Authenticatable, Authorizable, HasFactory, UserTrait;

    protected $primaryKey = 'id';
    protected $fillable = [
        'likeable_id', 'likeable_type'
    ];
    protected $hidden = [];
    protected $table = 'Like';

    public function likeable(): MorphTo
    {
        return $this->morphTo();
    }
}
