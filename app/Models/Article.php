<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class Article extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['user_id', 'title', 'body', 'category_id', 'published_at',];
    protected $casts = ['published_at' => 'datetime',];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function favoriteLists()
    {
        return $this->belongsToMany(FavoriteList::class, 'favorite_list_article')->withTimestamps();
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            //'author_name' => optional($this->user)->name, // 防止 null error
            //'tags' => $this->tags->pluck('name')->toArray(), // 傳回陣列，Meilisearch 支援
        ];
    }
}
