<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LikeController extends Controller
{
    public function newLike(Request $request): Response
    {
        $this->validate($request, [
            'likeable_id' => 'required',
            'likeable_type' => 'required',
        ]);
        /** @var bool $canCreate */
        $canCreate = $request->user()->can('create', Like::class);
        if (!$canCreate)
            return response([], 403);

        $newLike = new Like();
        $newLike->fill($request->all());
        $newLike->setUserId();

        /** @var bool $exists */
        $exists = Like::where('user_id', '=', $newLike->user_id)
            ->where('likeable_id', '=', $newLike->likeable_id)
            ->where('likeable_type', '=', $newLike->likeable_type)
            ->exists();
        if ($exists)
            return response([], 403);

        $newLike->save();
        return response($newLike, 201);
    }

    public function deleteLike(Request $request, int $likeId): Response
    {
        /** @var Like $like */
        $like = Like::findorfail($likeId);
        /** @var bool $canEdit */
        $canEdit = $request->user()->can('delete', $like);
        if (!$canEdit)
            return response([], 403);
        $like->delete();
        return response([]);
    }
}
