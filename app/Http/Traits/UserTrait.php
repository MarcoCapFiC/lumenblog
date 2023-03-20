<?php
namespace App\Http\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait UserTrait{

    private $loggedUserId = -1;
    public function getUserId(){
        /** @var User $user */
        $user = Auth::user();
        return $user->id;
    }

    public function setUserId(){
        $this->user_id = $this->getUserId();
        $this->save();
    }
}
