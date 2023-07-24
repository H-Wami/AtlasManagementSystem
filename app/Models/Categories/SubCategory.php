<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'main_category_id',
        'sub_category',
    ];

    // main_categoriesテーブルとリレーション　リレーション定義　1×多
    // 1側と結合 メソッド単数 belongsTo(対象先のモデル)
    public function mainCategory(){
        // リレーションの定義
        return $this->belongsTo('App\Models\Categories\MainCategory');
    }

    // postsテーブルとリレーション　リレーション定義　多×多
    // (関係するモデル、中間テーブル名、接続元(自分)の中間テーブルカラム、接続したい(相手)の中間テーブルカラム)
    public function posts(){
        return $this->belongsToMany('App\Models\Posts\Post', 'post_sub_categories', 'sub_category_id', 'post_id');// リレーションの定義
    }
}
