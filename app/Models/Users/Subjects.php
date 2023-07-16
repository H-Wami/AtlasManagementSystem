<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;

class Subjects extends Model
{
    const UPDATED_AT = null;


    protected $fillable = [
        'subject'
    ];

    // usersテーブルとリレーション　リレーション定義　多×多
    // (関係するモデル、中間テーブル名、接続元(自分)の中間テーブルカラム、接続したい(相手)の中間テーブルカラム)
    public function users(){
        return $this->belongsToMany('App\Models\Users\User', 'subject_users', 'subject_id', 'user_id');// リレーションの定義
    }
}
