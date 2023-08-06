<?php
namespace App\Calendars\Admin;

use Carbon\Carbon; // 日付を使うときのライブラリ

class CalendarWeek{
  protected $carbon;
  protected $index = 0;

  function __construct($date, $index = 0){
    $this->carbon = new Carbon($date);
    $this->index = $index;
  }

  function getClassName(){
    return "week-" . $this->index;
  }

  // 日の情報を取得
  function getDays(){
    $days = [];
    $startDay = $this->carbon->copy()->startOfWeek(); //初日 carbon(日付の操作)->copy()日付操作の影響なし
    $lastDay = $this->carbon->copy()->endOfWeek(); // 月末まで(終了日) carbon(日付の操作)->copy()日付操作の影響なし
    $tmpDay = $startDay->copy(); // 作業用の日作成


    while($tmpDay->lte($lastDay)){ // 月曜日~日曜日までループ
      if($tmpDay->month != $this->carbon->month){ // 月の比較 もし、違う月ならば(第1週の最初が前の月・最終週の最後が次の月ならば)
        $day = new CalendarWeekBlankDay($tmpDay->copy()); // 余白用CalenderWeekBlankDayオブジェクト追加
        $days[] = $day;
        $tmpDay->addDay(1);
        continue;
       }
       // 同じ月ならば、(全て同じ月の日ならば)
       $day = new CalendarWeekDay($tmpDay->copy()); // 通常CalenderWeekDayオブジェクト追加
       $days[] = $day;
       $tmpDay->addDay(1);
    }
    return $days;
  }
}
