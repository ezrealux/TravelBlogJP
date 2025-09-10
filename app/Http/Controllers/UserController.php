<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Users",
 *     description="使用者相關操作"
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users/{slug}",
     *     summary="取得使用者個人頁資訊",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="使用者的 slug",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="成功取得使用者資訊",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user", type="object"),
     *             @OA\Property(property="articles", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="favoriteLists", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="bio", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="找不到該使用者"
     *     )
     * )
     */
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
