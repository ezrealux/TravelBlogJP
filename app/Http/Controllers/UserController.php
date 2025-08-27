<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        $articles = $user->articles()->with('category','tags')->latest()->paginate(10);
        return view('users.show', compact('user', 'articles'));
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

}
