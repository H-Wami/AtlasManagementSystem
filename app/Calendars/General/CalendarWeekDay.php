<?php
namespace App\Calendars\General;

use App\Models\Calendars\ReserveSettings;
use Carbon\Carbon;
use Auth;

class CalendarWeekDay{
  protected $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  function getClassName(){
    return "day-" . strtolower($this->carbon->format("D")); // format()関数「D」指定=曜日を省略形式で取得 ex.day-sun(日),day-mon(月)
  }

  function pastClassName(){
    return;
  }

  /**
   * @return
   */

   function render(){
     return '<p class="day">' . $this->carbon->format("j"). '日</p>'; // format()関数「j」指定=先頭にゼロをつけない形式で日付を取得 ex.15
   }

   // 予約する選択肢
   function selectPart($ymd){
     $one_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first(); // ReserveSettingsモデルと関連するusersテーブルを取得->setting_reserveカラムと$ymdが同じ->setting_partカラムが1の情報を格納
     $two_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first(); // setting_partカラムが2の情報を格納
     $three_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first(); // setting_partカラムが3の情報を格納
     // $one_part_frameの場合
     if($one_part_frame){
       $one_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first()->limit_users; // $one_part_frameを取得してlimit_users(人数)カラムに格納
     }else{ // それ以外の場合
       $one_part_frame = '0';
     }
     // $two_part_frameの場合
     if($two_part_frame){
       $two_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first()->limit_users; // $two_part_frameを取得してlimit_users(人数)カラムに格納
     }else{ // それ以外の場合
       $two_part_frame = '0';
     }
     // $three_part_frameの場合
     if($three_part_frame){
       $three_part_frame = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first()->limit_users; // $three_part_frameを取得してlimit_users(人数)カラムに格納
     }else{ // それ以外の場合
       $three_part_frame = '0';
     }

     $html = [];
     $html[] = '<select name="getPart[]" class="border-primary" style="width:70px; border-radius:5px;" form="reserveParts">'; // 予約選択を表示する
     $html[] = '<option value="" selected></option>';
     if($one_part_frame == "0"){
       $html[] = '<option value="1" disabled>リモ1部(残り0枠)</option>';
     }else{
       $html[] = '<option value="1">リモ1部(残り'.$one_part_frame.'枠)</option>';
     }
     if($two_part_frame == "0"){
       $html[] = '<option value="2" disabled>リモ2部(残り0枠)</option>';
     }else{
       $html[] = '<option value="2">リモ2部(残り'.$two_part_frame.'枠)</option>';
     }
     if($three_part_frame == "0"){
       $html[] = '<option value="3" disabled>リモ3部(残り0枠)</option>';
     }else{
       $html[] = '<option value="3">リモ3部(残り'.$three_part_frame.'枠)</option>';
     }
     $html[] = '</select>';
     return implode('', $html);
   }

   function getDate(){
     return '<input type="hidden" value="'. $this->carbon->format('Y-m-d') .'" name="getData[]" form="reserveParts">'; // 日付のフォーマットを非表示で取得 予約フォームに使用
   }

   function everyDay(){
     return $this->carbon->format('Y-m-d'); //日付のフォーマット
   }

   function authReserveDay(){
     return Auth::user()->reserveSettings->pluck('setting_reserve')->toArray(); //ログインユーザー情報取得->ルーティングのメソッド->setting_reserveカラムの値を取得->配列にする
   }

   function authReserveDate($reserveDate){
     return Auth::user()->reserveSettings->where('setting_reserve', $reserveDate); //ログインユーザー情報取得->ルーティングのメソッド->setting_reserveカラムと$reserveDateが同じものを持ってくる
   }

}
