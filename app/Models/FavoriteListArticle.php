<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FavoriteListArticle extends Pivot
{
    protected $table = 'favorite_list_article';

    protected $fillable = ['favorite_list_id', 'article_id'];
}
