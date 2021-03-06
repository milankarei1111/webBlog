<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleCategory extends Model
{
    // 使用軟刪除
    use SoftDeletes;

    protected $primaryKey = 'category_id';
    protected $fillable = ['name', 'description'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id');
    }

}
