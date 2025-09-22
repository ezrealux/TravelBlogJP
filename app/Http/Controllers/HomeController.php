<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $articles = Article::with('user','category','tags')->latest()->paginate(10);
        return view('home.index', compact('articles'));
    }
    
    public function show(User $user)
    {
        $articles = $user->articles()->with('category','tags')->latest()->paginate(10);
        return view('users.show', compact('user', 'articles'));
    }
}