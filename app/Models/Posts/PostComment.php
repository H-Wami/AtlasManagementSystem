<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;

class PostComment extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'post_id',
        'user_id',
        'comment',
    ];

    // postsテーブルとリレーション　リレーション定義　1×多
    // 1側と結合 メソッド単数 belongsTo(対象先のモデル)
    public function post(){
        return $this->belongsTo('App\Models\Posts\Post');
    }

    // コメントしているかどうか
    public function commentUser($user_id){
        return User::where('id', $user_id)->first();// usersテーブルのidカラムと$user_idが一致している->値を取得
    }
}
