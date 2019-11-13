<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    // 使用軟刪除
    use SoftDeletes;

    protected $primaryKey = 'category_id';

    public function article()
    {
        return $this->hasMany(Article::class);
    }

}
