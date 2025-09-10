<?php

namespace App\Docs\Schemas;

/**
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     description="使用者資料結構",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="avatar", type="string", format="url", nullable=true, example="https://example.com/avatar.jpg"),
 *     @OA\Property(property="is_admin", type="boolean", example=false),
 *     @OA\Property(property="role", type="string", example="editor"),
 *     @OA\Property(property="bio", type="string", example="Full-stack developer from Tokyo."),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-09-01T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-09-10T10:10:00Z")
 * )
 */

class User
{
    // 這個 class 只放注解用，不需要實作內容
}