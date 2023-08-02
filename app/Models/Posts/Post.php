<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];

    // usersテーブルとリレーション　リレーション定義　1×多
    // 1側と結合 メソッド単数 belongsTo(対象先のモデル)
    public function user(){
        return $this->belongsTo('App\Models\Users\User');
    }

    // post_commentsテーブルとリレーション　リレーション定義　1×多
    // 多側と結合 メソッド複数形 hasMany(対象先のモデル)
    public function postComments(){
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    // sub_categoryテーブルとリレーション　リレーション定義　多×多
    // (関係するモデル、中間テーブル名、接続元(自分)の中間テーブルカラム、接続したい(相手)の中間テーブルカラム)
    public function subCategories(){
        return $this->belongsToMany('App\Models\Categories\SubCategory', 'post_sub_categories', 'post_id', 'sub_category_id');// リレーションの定義
    }

    // コメント数
    public function commentCounts($post_id){
        return Post::with('postComments')->find($post_id)->postComments(); // postsテーブルと関連するpost_commentsテーブルを取得->$post_idと同じレコードを一つだけ取得する->postCommentsメソッド使用
    }
}
