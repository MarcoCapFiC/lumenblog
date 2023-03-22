<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Like::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $likeableType = $this->faker->randomElement(['post', 'comment']);
        if ($likeableType == 'post')
            $likeableId = Post::all()->random()->id;
        else
            $likeableId = Comment::all()->random()->id;

        $newComment = [
            'user_id' => User::all()->random()->id,
            'likeable_type' => $likeableType,
            'likeable_id' => $likeableId,
        ];

        return $newComment;
    }
}
