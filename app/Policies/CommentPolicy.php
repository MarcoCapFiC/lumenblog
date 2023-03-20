<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id and $user->subscription === 'premium';
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id and $user->subscription === 'premium';
    }
}
