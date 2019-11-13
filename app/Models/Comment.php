<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //使用軟刪除
    use SoftDeletes;

    protected $primaryKey = 'comment_id';
}
