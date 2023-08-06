<?php
namespace App\Calendars\Admin;

// 日カレンダーをカスタマイズ クラス名とHTMLだけ別の処理になるようなクラス作成
class CalendarWeekBlankDay extends CalendarWeekDay{

  function getClassName(){
    return "day-blank"; // クラス名「day-blank」
  }

  function render(){
    return ''; // 何も出力しない
  }

  function everyDay(){
    return '';
  }

  function dayPartCounts($ymd = null){
    return '';
  }

  function dayNumberAdjustment(){
    return '';
  }
}
