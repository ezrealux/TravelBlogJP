<?php

namespace App\Docs\Schemas;

/**
 * @OA\Schema(
 *     schema="Article",
 *     title="Article",
 *     description="文章資料結構",
 *     @OA\Property(property="id", type="integer", example=123),
 *     @OA\Property(property="user_id", type="integer", example=1, description="作者 User ID"),
 *     @OA\Property(property="title", type="string", example="探索東京的美食之旅"),
 *     @OA\Property(property="body", type="string", example="這是一篇關於東京美食的詳細介紹..."),
 *     @OA\Property(property="published_at", type="string", format="date-time", nullable=true, example="2023-09-10T08:00:00Z"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-08-20T10:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-09-05T15:30:00Z"),
 *     @OA\Property(property="category_id", type="integer", nullable=true, example=5, description="文章分類 ID")
 * )
 */
class Article
{
    // 這個 class 只放注解用，不需要實作內容
}