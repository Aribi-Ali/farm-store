<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function getUser(User $user)
    {

        return response()->json($user);
    }
}
