<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    // 使用軟刪除
    use SoftDeletes;

    protected $primaryKey = 'article_id';

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class,'article_id');
    }
}
