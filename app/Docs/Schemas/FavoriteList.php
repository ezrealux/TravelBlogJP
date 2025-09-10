<?php

namespace App\Docs\Schemas;

/**
 * @OA\Schema(
 *     schema="FavoriteList",
 *     title="FavoriteList",
 *     description="使用者收藏清單資料結構",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", description="收藏清單所屬使用者ID", example=123),
 *     @OA\Property(property="name", type="string", example="旅遊收藏"),
 *     @OA\Property(property="description", type="string", nullable=true, example="收集所有旅遊相關文章"),
 *     @OA\Property(property="articles_count", type="integer", description="收藏清單中文章數量", example=15),
 *     @OA\Property(property="is_default", type="boolean", description="是否為使用者的預設收藏清單", example=true),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-09-01T08:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-09-10T10:30:00Z")
 * )
 */

class FavoriteList
{
    // 這個 class 只放注解用，不需要實作內容
}