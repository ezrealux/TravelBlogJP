<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        // 確保有資料可用
        if (Category::count() === 0) {
            Category::factory(5)->create();
        }

        if (Tag::count() === 0) {
            Tag::factory(10)->create();
        }

        if (User::count() === 0) {
            $this->call(UserSeeder::class); // 沒有 user 就先跑 UserSeeder
        }*/

        $categories = Category::all();
        $tags = Tag::all();
        $users = User::all();

        // 建立 20 篇文章
        Article::factory(20)->create()->each(function ($article) use ($categories, $tags, $users) {
            // 指派作者
            $article->user_id = $users->random()->id;

            // 指派分類
            $article->category_id = $categories->random()->id;
            $article->save();

            // 指派標籤
            $randomTags = $tags->random(rand(2, 5))->pluck('id')->toArray();
            $article->tags()->sync($randomTags);
        });
    }
}

