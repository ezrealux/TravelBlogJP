<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\Tag;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return view('search.index', [
                'articles' => collect(),
                'query' => ''
            ]);
        }

        // 使用 Scout 搜尋
        $articles = Article::search($query)->get();

        return view('search.index', compact('articles', 'query'));
    }
}
