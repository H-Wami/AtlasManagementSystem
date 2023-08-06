<?php

namespace App\Models\Calendars;

use Illuminate\Database\Eloquent\Model;

class ReserveSettings extends Model
{
    const UPDATED_AT = null;
    public $timestamps = false;

    protected $fillable = [
        'setting_reserve',
        'setting_part',
        'limit_users',
    ];

    // usersテーブルとリレーション　リレーション定義　多×多
    // (関係するモデル、中間テーブル名、接続元(自分)の中間テーブルカラム、接続したい(相手)の中間テーブルカラム)
    public function users(){
        return $this->belongsToMany('App\Models\Users\User', 'reserve_setting_users', 'reserve_setting_id', 'user_id')->withPivot('reserve_setting_id', 'id');
    }
}
