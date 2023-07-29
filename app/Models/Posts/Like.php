<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'like_user_id',
        'like_post_id'
    ];

    // いいねの数
    public function likeCounts($post_id){
        return $this->where('like_post_id', $post_id)->get()->count(); //likesテーブルのlike_post_idカラムと$post_idが一致している投稿を取得して、数を表示する。
    }
}
