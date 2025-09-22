<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\FavoriteList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use OpenApi\Annotations as OA;

class FavoriteController extends Controller
{
    use AuthorizesRequests;

    /**
     * @OA\Post(
     *     path="/api/favorite-lists",
     *     summary="Create a new favorite list",
     *     description="Create a new favorite list for the authenticated user.",
     *     operationId="storeFavoriteList",
     *     tags={"Favorite Lists"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Schema(
     *                 type="object",
     *                 required={"name"},
     *                 @OA\Property(property="name", type="string", description="The name of the favorite list", example="My Favorite List")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Favorite list created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/FavoriteList")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/api/favorite-lists/{favoriteListId}",
     *     summary="Update an existing favorite list",
     *     description="Update the name of a specific favorite list.",
     *     operationId="updateFavoriteList",
     *     tags={"Favorite Lists"},
     *     @OA\Parameter(
     *         name="favoriteListId",
     *         in="path",
     *         description="ID of the favorite list to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Schema(
     *                 type="object",
     *                 required={"name"},
     *                 @OA\Property(property="name", type="string", description="The new name of the favorite list", example="Updated Favorite List Name")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Favorite list updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/FavoriteList")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden, unauthorized action"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Favorite list not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function update(Request $request, FavoriteList $favoriteList)
    {
        // update name
        $this->authorize('update', $favoriteList);
        $request->validate([
            'name' => 'required|string|max:255|unique:favorite_lists,name,' . $favoriteList->id . ',id,user_id,' . auth()->id(),
        ]);
        $favoriteList->update(['name' => $request->name]);

        return redirect()->back()->with('success', '更新成功');
    }

    /**
     * @OA\Delete(
     *     path="/api/favorite-lists/{favoriteListId}",
     *     summary="Delete a favorite list",
     *     description="Delete a specific favorite list.",
     *     operationId="deleteFavoriteList",
     *     tags={"Favorite Lists"},
     *     @OA\Parameter(
     *         name="favoriteListId",
     *         in="path",
     *         description="ID of the favorite list to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Favorite list deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden, cannot delete default list"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Favorite list not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function destroy(FavoriteList $favoriteList)
    {
        $this->authorize('delete', $favoriteList);
        if ($favoriteList->is_default) {
            return response()->json(['error' => '不能刪除預設清單'], 403);
        }
        $favoriteList->delete();

        return redirect()->back()->with('success', '刪除成功');
    }
}
