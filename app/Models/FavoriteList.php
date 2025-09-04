<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FavoriteListArticle;

class FavoriteList extends Model
{
    protected $fillable = ['user_id', 'name', 'is_default', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Relation type     ->                  <-                  Example
    //One to One        hasOne()            belongsTo()	        User ↔ UserProfile
    //One to Many       hasMany()           belongsTo()	        User → Posts（User 有多篇文章）
    //Many to One       (belongsTo())       hasMany()	        Post → User（多篇文章屬於一個使用者）
    //Many to Many      belongsToMany()     belongsToMany()	    Article ↔ FavoriteList
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'favorite_list_article')
                    ->using(FavoriteListArticle::class)
                    ->withTimestamps();
        //$favoriteList->articles()->attach($id);	自動 +1
        //$favoriteList->articles()->detach($id);	自動 -1
    }

}