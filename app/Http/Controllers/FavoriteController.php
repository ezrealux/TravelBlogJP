<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    // 先預設一個「預設清單」，未來可以讓使用者自建
    public function store(Article $article)
    {
        $user = auth()->user();

        // 如果傳入清單 ID
        if ($request->filled('list_id')) {
            $list = $user->favoriteLists()->findOrFail($request->list_id);
        } else {
            // 建立新清單
            $list = $user->favoriteLists()->create([
                'name' => $request->input('list_name', '新收藏清單'),
                'is_default' => false,
            ]);
        }

        $list->articles()->syncWithoutDetaching([$article->id]);
        return back()->with('success', "已收藏到清單：{$list->name}");
    }

    public function destroy(FavoriteList $list, Article $article)
    {
        $this->authorize('update', $list);
        $list->articles()->detach($article->id);

        return back()->with('success', '已移除收藏');
    }

    public function index()
    {
        $lists = auth()->user()->favoriteLists()->with('articles')->get();

        return view('favorites.index', compact('lists'));
    }
}
