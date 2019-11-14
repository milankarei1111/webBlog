<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    //使用軟刪除
    use SoftDeletes;

    protected $primaryKey = 'comment_id';

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}
