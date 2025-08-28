<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        $articles = $user->articles()->latest()->paginate(10);
        $favoriteLists = $user->favoriteLists()->with('articles')->get();
        $bio = $user->bio;

        return view('users.show', compact('user', 'articles', 'favoriteLists', 'bio'));
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

}
