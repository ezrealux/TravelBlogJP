<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:favorite_lists,name,NULL,id,user_id,' . auth()->id(),
        ]);
        $list = auth()->user()->favoriteLists()->create([
            'name' => $request->name,
            'is_default' => false,
        ]);
        dd($list);
        return response()->json($list);
    }

    public function update(Request $request, FavoriteList $favoriteList)
    {
        // update name
        $this->authorize('update', $favoriteList);
        $request->validate([
            'name' => 'required|string|max:255|unique:favorite_lists,name,' . $favoriteList->id . ',id,user_id,' . auth()->id(),
        ]);
        $favoriteList->update(['name' => $request->name]);

        return response()->json($favoriteList);
    }

    public function destroy(FavoriteList $favoriteList)
    {
        $this->authorize('delete', $favoriteList);
        if ($favoriteList->is_default) {
            return response()->json(['error' => '不能刪除預設清單'], 403);
        }
        $favoriteList->delete();

        return response()->json(['status' => 'ok']);
    }
}
