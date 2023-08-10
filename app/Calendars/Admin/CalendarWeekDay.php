<?php
namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;

class CalendarWeekDay{
  protected $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  function getClassName(){
    return "day-" . strtolower($this->carbon->format("D")); // format()関数「D」指定=曜日を省略形式で取得 ex.day-sun(日),day-mon(月)
  }

  function render(){
    return '<p class="day">' . $this->carbon->format("j") . '日</p>'; // format()関数「j」指定=先頭にゼロをつけない形式で日付を取得 ex.15
  }

  function everyDay(){
    return $this->carbon->format("Y-m-d"); //日付のフォーマット
  }

  function dayPartCounts($ymd){
    $html = [];
    $one_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first(); // ReserveSettingsモデルと関連するusersテーブルを取得->setting_reserveカラムと$ymdが同じ->setting_partカラムが1の情報を格納
    $two_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first(); // setting_partカラムが2の情報を格納
    $three_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first(); // setting_partカラムが3の情報を格納

    // 予約出来る部と予約している人数表示
    $html[] = '<div class="day_part_container">';
    // $one_partの場合
    if($one_part){
      $html[] = '<div class="day_part_contents">';
      $html[] = '<p class="day_part">1部</p>';
      $html[] = '<p class="day_part">' . $one_part->users($one_part->id)->count() . '</p>'; // $one_partの値取得->リレーションメソッド使用->count関数で各部の予約している人数を取得
      $html[] = '</div>';
    }
    // $two_partの場合
    if($two_part){
      $html[] = '<div class="day_part_contents">';
      $html[] = '<p class="day_part">2部</p>';
      $html[] = '<p class="day_part">' . $two_part->users($two_part->id)->count() . '</p>';
      $html[] = '</div>';
    }
    // $three_partの場合
    if($three_part){
      $html[] = '<div class="day_part_contents">';
      $html[] = '<p class="day_part">3部</p>';
      $html[] = '<p class="day_part">' . $three_part->users($three_part->id)->count() . '</p>';
      $html[] = '</div>';
    }
    $html[] = '</div>';

    return implode("", $html);
  }


  function onePartFrame($day){
    $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first();
    if($one_part_frame){
      $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first()->limit_users;
    }else{
      $one_part_frame = "20";
    }
    return $one_part_frame;
  }
  function twoPartFrame($day){
    $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first();
    if($two_part_frame){
      $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first()->limit_users;
    }else{
      $two_part_frame = "20";
    }
    return $two_part_frame;
  }
  function threePartFrame($day){
    $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first();
    if($three_part_frame){
      $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first()->limit_users;
    }else{
      $three_part_frame = "20";
    }
    return $three_part_frame;
  }

  //
  function dayNumberAdjustment(){
    $html = [];
    $html[] = '<div class="adjust-area">';
    $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="1" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="2" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="3" type="text" form="reserveSetting"></p>';
    $html[] = '</div>';
    return implode('', $html);
  }
}
