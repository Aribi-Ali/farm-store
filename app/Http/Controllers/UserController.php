<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function getAuthUserWithDetails()
    {
        return response()->json(Auth::user());
    }
    public function getUser(User $user)
    {

        return response()->json($user);
    }
}
