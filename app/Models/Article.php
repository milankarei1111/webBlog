<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    // 使用軟刪除
    use SoftDeletes;

    protected $primaryKey = 'article_id';
}
