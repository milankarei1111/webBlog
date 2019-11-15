<?php

use App\Models\ArticleCategory;
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
        //
        factory(ArticleCategory::class,1)->create();
    }
}
