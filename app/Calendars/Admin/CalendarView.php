<?php
namespace App\Calendars\Admin;
use Carbon\Carbon; // 日付を使うときのライブラリ
use App\Models\Users\User;

// スクール予約確認ページ
class CalendarView{
  private $carbon;

  // コンストラクタで受け取った日付を元にCarbonオブジェクト作成
  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  // カレンダーの年月表示(タイトル)
  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  // カレンダーの出力
  public function render(){
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table m-auto border">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th class="border">月</th>';
    $html[] = '<th class="border">火</th>';
    $html[] = '<th class="border">水</th>';
    $html[] = '<th class="border">木</th>';
    $html[] = '<th class="border">金</th>';
    $html[] = '<th class="border day-sat">土</th>';
    $html[] = '<th class="border day-sun">日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';

    $weeks = $this->getWeeks(); // 週カレンダーオブジェクトの配列取得

    foreach($weeks as $week){ // 一週ずつ処理
      $html[] = '<tr class="'.$week->getClassName().'">'; // 週カレンダーオブジェクトを使ってHTMLのクラス名出力
      $days = $week->getDays(); // 週カレンダーオブジェクトから日カレンダーオブジェクトの配列取得
      foreach($days as $day){ // 日カレンダーオブジェクトを1日ずつ処理(ループ)
        $startDay = $this->carbon->format("Y-m-01"); // 初日
        $toDay = $this->carbon->format("Y-m-d"); // 本日
        // もし、過去の日付ならば
        if($startDay <= $day->everyDay() && $toDay > $day->everyDay()){ // >=$day->everyDay()から変更
          $html[] = '<td class="past-day border ' . $day->getClassName() . '">';
        }else{ // それ以外の日付は(今日以降)
          $html[] = '<td class="border '.$day->getClassName().'">'; //日カレンダーオブジェクトを使ってHTMLのクラス名出力
        }
        $html[] = $day->render();
        $html[] = $day->dayPartCounts($day->everyDay());
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';

    return implode("", $html);
  }

  // 週の情報を取得
  protected function getWeeks(){
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth(); //初日 carbon(日付の操作)->copy()日付操作の影響なし
    $lastDay = $this->carbon->copy()->lastOfMonth(); // 月末まで(終了日) carbon(日付の操作)->copy()日付操作の影響なし
    $week = new CalendarWeek($firstDay->copy()); // 1週目・1日を指定してCalenderWeek作成
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek(); // 作業用の日作成 翌週の月曜日が欲しい=初日に+7日した後に週の開始日に移動する
    while($tmpDay->lte($lastDay)){ // 一週毎に+7日して$tmpDayを翌週に移動(ループ)
      $week = new CalendarWeek($tmpDay, count($weeks)); // CalenderWeek作成 第2引数count($weeks)=何週目かを週カレンダーオブジェクトに伝える
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}
