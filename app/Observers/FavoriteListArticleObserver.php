<?php

namespace App\Observers;

use App\Models\FavoriteListArticle;
use App\Models\FavoriteList;

class FavoriteListArticleObserver
{
    /**
     * Handle the FavoriteListArticle "created" event.
     */
    public function created(FavoriteListArticle $pivot)
    {
        FavoriteList::where('id', $pivot->favorite_list_id)->increment('articles_count');
    }

    public function deleted(FavoriteListArticle $pivot)
    {
        FavoriteList::where('id', $pivot->favorite_list_id)->decrement('articles_count');
    }

    /**
     * Handle the FavoriteListArticle "updated" event.
     */
    public function updated(FavoriteListArticle $favoriteListArticle): void
    {
        //
    }

    /**
     * Handle the FavoriteListArticle "restored" event.
     */
    public function restored(FavoriteListArticle $favoriteListArticle): void
    {
        //
    }

    /**
     * Handle the FavoriteListArticle "force deleted" event.
     */
    public function forceDeleted(FavoriteListArticle $favoriteListArticle): void
    {
        FavoriteList::where('id', $pivot->favorite_list_id)->decrement('articles_count');
    }
}
