<?php

namespace App\Http\Controllers;

use App\Exceptions\SubscriptionPlanException;
use App\Http\Traits\UserTrait;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    public function showAllComments(): Response
    {
        return response(Comment::all());
    }

    public function showSinglePostComments(Request $request): Response
    {
        /*
        $query = DB::table('Comment')
            ->join('User', 'Comment.user_id', '=', 'User.id')
            ->select('Comment.*', 'User.id', 'User.first_name', 'User.last_name', 'User.picture')
            ->where('Comment.post_id', '=', $postId)
            ->get();
        */
        $query = Comment::with('user');
        $postId = $request->get('post_id');
        if ($postId)
            $query = $query->where('Comment.post_id', '=', $postId);

        $query = $query->get();
        return response($query);
    }

    public function showOneComment($commentId): Response
    {
        $query = Comment::with('user')
            ->where('Comment.id', '=', $commentId)
            ->get();
        return response($query);
    }

    public function newComment(Request $request): Response
    {
        $this->validate($request, [
            'post_id' => 'required',
            'content' => 'required'
        ]);
        $newComment = new Comment();
        $newComment->fill($request->all());
        $newComment->setUserId();
        $newComment->save();
        return response($newComment, 201);
    }

    public function editComment(Request $request, $commentId): Response
    {
        /** @var Comment $editComment */
        $editComment = Comment::findorfail($commentId);
        /** @var bool $canEdit */
        $canEdit = $request->user()->can('update', $editComment);
        if (!$canEdit)
            throw new SubscriptionPlanException();

        $editComment->update($request->all());
        return response($editComment);
    }

    public function deleteComment(Request $request, int $commentId): Response
    {
        /** @var Comment $comment */
        $comment = Comment::findorfail($commentId);
        /** @var bool $canEdit */
        $canEdit = $request->user()->can('delete', $comment);
        if (!$canEdit)
            throw new SubscriptionPlanException();

        $comment->delete();
        return response([]);
    }
}
