<?php
namespace App\Calendars\General;

// 日カレンダーをカスタマイズ クラス名とHTMLだけ別の処理になるようなクラス作成
class CalendarWeekBlankDay extends CalendarWeekDay{
  function getClassName(){
    return "day-blank"; // クラス名「day-blank」
  }

  /**
   * @return
   */

   function render(){
     return ''; // 何も出力しない
   }

   function selectPart($ymd){
     return '';
   }

   function getDate(){
     return '';
   }

   function cancelBtn(){
     return '';
   }

   function everyDay(){
     return '';
   }

}
