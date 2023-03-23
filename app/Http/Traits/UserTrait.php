<?php
namespace App\Http\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait UserTrait{

    public function getUserId(){
        /** @var User $user */
        $user = Auth::user();
        return $user->id;
    }

    public function setUserId(){
        $this->user_id = $this->getUserId();
    }
}
