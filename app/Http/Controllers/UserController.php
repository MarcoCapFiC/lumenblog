<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function showAllUsers(): Response
    {
        $query = User::all();
        return response($query);
    }

    public function addUser(Request $request): Response
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:User',
            'password' => 'required',
            'picture' => 'required',
            'subscription' => 'required'
        ]);
        $newUser = new User();
        $newUser->fill($request->all());
        $newUser->password = $request->get('password');
        $newUser->save();
        return response($newUser, 201);
    }

    public function loginUser(Request $request): Response
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        $api_token = User::select('User.api_token')
            ->where('User.email', '=', $request->get('email'))
            ->where('User.password', '=', $request->get('password'))
            ->get();
        if ($api_token->count() <= 0)
            return response([], 403);

        return response($api_token);
    }
}
