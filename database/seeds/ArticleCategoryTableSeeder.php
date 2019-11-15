<?php

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class ArticleCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 產生1個分類
        factory(ArticleCategory::class,1)->create();

        // 1個分類 2篇文章 2個評論
        // factory(ArticleCategory::class, 1)->create()
        //     ->each(function($category) {
        //         $category->article()->saveMany( factory(Article::class, 2)->make() )
        //                 ->each(function($article){
        //                     $article->comment()->save(factory(Comment::class)->make());
        //                 });
        });
    }
}
