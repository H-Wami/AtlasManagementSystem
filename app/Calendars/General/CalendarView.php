<?php
namespace App\Calendars\General;

use Carbon\Carbon; // 日付を使うときのライブラリ
use Auth;

// スクール予約ページ
class CalendarView{

  private $carbon;
  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  // カレンダーの年月表示(タイトル)
  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  // カレンダーの出力
  function render(){
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th>土</th>';
    $html[] = '<th>日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';

    $weeks = $this->getWeeks(); // 週カレンダーオブジェクトの配列取得

    foreach($weeks as $week){ // 一週ずつ処理
      $html[] = '<tr class="'.$week->getClassName().'">'; // 週カレンダーオブジェクトを使ってHTMLのクラス名出力
      $days = $week->getDays(); // 週カレンダーオブジェクトから日カレンダーオブジェクトの配列取得
      foreach($days as $day){ // 日カレンダーオブジェクトを1日ずつ処理(ループ)
        $startDay = $this->carbon->copy()->format("Y-m-01"); // 初日
        $toDay = $this->carbon->copy()->format("Y-m-d"); // 本日
        // もし、過去の日付ならば
        if($startDay <= $day->everyDay() && $toDay > $day->everyDay()){ // >=$day->everyDay()から変更
          $html[] = '<td class="past-day ' . $day->getClassName() . '">'; //calendar-tdから変更
        }else{ // それ以外の日付は(今日以降)
          $html[] = '<td class="calendar-td '.$day->getClassName().'">'; //日カレンダーオブジェクトを使ってHTMLのクラス名出力
        }
        $html[] = $day->render();

        // 予約のあるなし判定
        // もし予約が入っていたら
        if(in_array($day->everyDay(), $day->authReserveDay())){
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part; // 日付->authReserveDateメソッド(毎日)->値取得->何部(1~3)の値が入っているものを格納
          if($reservePart == 1){ // もし$reservePartの値が1だったら
            $reservePart = "リモ1部";
          }else if($reservePart == 2){ // もし$reservePartの値が2だったら
            $reservePart = "リモ2部";
          }else if($reservePart == 3){ // もし$reservePartの値が3だったら
            $reservePart = "リモ3部";
          }
          // もし、予約している日付が過去の日付ならば
          if($startDay <= $day->everyDay() && $toDay > $day->everyDay()){ // >= $day->everyDay()から変更
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">' . $reservePart . ' 参加</p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }else{ // もし、予約している日付が今日以降の日付ならば
            $html[] = '<button type="submit" class="reserve-modal-open btn btn-danger p-0 w-75" name="delete_date" style="font-size:12px" value="' . $day->authReserveDate($day->everyDay())->first()->setting_reserve . '"
            setting_reserve="' . $day->authReserveDate($day->everyDay())->first()->setting_reserve . '"
            setting_part="' . $day->authReserveDate($day->everyDay())->first()->setting_part . '" setting_reserve="' . $day->authReserveDate($day->everyDay())->first()->setting_reserve . '"
            id="' . $day->authReserveDate($day->everyDay())->first()->id . '">' . $reservePart . '</button>'; // キャンセルにつながるボタン表示
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">'; // deletePartsから修正
          }
        // もし予約が入ってなかったら
        }else{
          // もし、予約していない日付が過去の日付ならば
          if ($startDay <= $day->everyDay() && $toDay > $day->everyDay()) {
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">受付終了</p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          } else { // もし、予約していない日付が今日以降の日付ならば
          $html[] = $day->selectPart($day->everyDay()); // 予約の選択肢表示
          }
        }
        $html[] = $day->getDate();
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    // 予約登録フォーム
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">'.csrf_field().'</form>';
    // 予約削除(キャンセル)フォーム
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">'.csrf_field().'</form>';
    return implode('', $html);
  }

  // 週の情報を取得
  protected function getWeeks(){
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth(); //初日 carbon(日付の操作)->copy()日付操作の影響なし
    $lastDay = $this->carbon->copy()->lastOfMonth(); // 月末まで(終了日) carbon(日付の操作)->copy()日付操作の影響なし
    $week = new CalendarWeek($firstDay->copy()); // 1週目・1日を指定してCalenderWeek作成
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek(); // 作業用の日作成 翌週の月曜日が欲しい=初日に+7日した後に週の開始日に移動する
    while($tmpDay->lte($lastDay)){  // 一週毎に+7日して$tmpDayを翌週に移動(ループ)
      $week = new CalendarWeek($tmpDay, count($weeks)); // CalenderWeek作成 第2引数count($weeks)=何週目かを週カレンダーオブジェクトに伝える
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}
