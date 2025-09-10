<?php

namespace App\Docs\Schemas;

/**
 * @OA\Schema(
 *     schema="Category",
 *     title="Category",
 *     description="文章分類資料結構，支持階層分類",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="旅遊"),
 *     @OA\Property(property="slug", type="string", example="travel"),
 *     @OA\Property(property="parent_id", type="integer", nullable=true, description="父分類ID，null代表無父分類", example=null),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-09-01T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-09-10T00:00:00Z")
 * )
 */

class Category
{
    // 這個 class 只放注解用，不需要實作內容
}