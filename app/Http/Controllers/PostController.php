<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function showAllPosts(): Response
    {
        /*
        $query = DB::table('Post')
            ->join('User', 'User.id', '=', 'Post.user_id')
            ->select('Post.*', 'User.id', 'User.first_name', 'User.last_name', 'User.picture')
            ->get();
        */
        $allPosts = Post::with('user')
            ->withCount('comments')
            ->get();
        return response($allPosts);
    }

    public function showOnePost(Request $request, $postId): Response
    {
        /*
        $query = DB::table('Post')
            ->join('User', 'User.id', '=', 'Post.user_id')
            ->where('Post.id', '=', $postId)
            ->get();
        */
        $tables = ['user'];
        $showComments = $request->get('comments');
        if ($showComments == 1)
            $tables[] = 'comments';
        /** @var Post $post */
        $post = Post::with($tables)
            ->where('Post.id', '=', $postId)
            ->get();

        return response($post);
    }

    public function newPost(Request $request): Response
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ]);
        /** @var Post $newPost */
        $newPost = new Post();
        $newPost->fill($request->all());
        $newPost->setUserId();
        $newPost->save();
        return response($newPost, 201);
    }

    public function editPost($postId, Request $request): Response
    {
        /** @var Post $editPost */
        $editPost = Post::findOrFail($postId);
        /** @var bool $canEdit */
        $canEdit = $request->user()->can('update', $editPost);
        if (!$canEdit)
            return response([], 403);

        $editPost->update($request->all());
        return response($editPost);
    }

    public function deletePost(Request $request, $postId): Response
    {
        /** @var Post $post */
        $post = Post::findorfail($postId);
        /** @var bool $canDelete */
        $canDelete = $request->user()->can('delete', $post);
        if (!$canDelete)
            return response([], 403);

        $post->delete();
        return response([]);
    }
}
