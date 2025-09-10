<?php

namespace App\Docs\Schemas;

/**
 * @OA\Schema(
 *     schema="Tag",
 *     title="Tag",
 *     description="標籤資料結構",
 *     @OA\Property(property="id", type="integer", example=10),
 *     @OA\Property(property="name", type="string", example="旅行"),
 *     @OA\Property(property="slug", type="string", example="travel"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T10:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-10T12:00:00Z")
 * )
 */

class Tag
{
    // 這個 class 只放注解用，不需要實作內容
}