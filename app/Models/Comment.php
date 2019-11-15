<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    //使用軟刪除
    use SoftDeletes;

    protected $primaryKey = 'comment_id';
    protected $fillable = ['content','article_id', 'user_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}
