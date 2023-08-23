@extends('layouts.sidebar')

@section('content')
<!-- スクール予約枠登録画面表示 -->
<div class="reserve_section">
  <div class="reserve_container">
    <div class="calendar_frame">
      <!-- カレンダータイトル -->
      <p class="calendar_title">{{ $calendar->getTitle() }}</p>
      <!-- カレンダー本体 -->
      <div>{!! $calendar->render() !!}</div>
      <!-- 登録ボタン -->
      <div class="adjust-table-btn">
        <input type="submit" class="btn btn-primary" value="登録" form="reserveSetting" onclick="return confirm('登録してよろしいですか？')">
      </div>
    </div>
  </div>
</div>
  @endsection
