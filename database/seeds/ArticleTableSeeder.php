<?php

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 只填充文章
        // factory(Article::class, 1)->create();

        factory(Article::class, 1)->create()
        ->each(function($article) {
            // 1篇文章關聯1篇評論
            // $article->comments()->save(factory(Comment::class)->make());
             // 1篇文章關聯2篇評論
            $article->comments()->saveMany(factory(Comment::class, 2)->make());
        });
    }
}
