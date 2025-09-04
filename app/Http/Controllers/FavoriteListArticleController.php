<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FavoriteListArticleController extends Controller
{
    public function sync(Request $request, Article $article)
    {
        $user = auth()->user();
        $listIds = $user->favoriteLists()->pluck('id')->toArray();

        $validListIds = collect($request->lists ?? [])
            ->filter(fn($id) => in_array($id, $allowedListIds))
            ->toArray();

        $article->favoriteLists()->sync($validListIds);

        return response()->json(['status' => 'ok']);
    }
}
