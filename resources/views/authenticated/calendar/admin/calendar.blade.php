@extends('layouts.sidebar')

@section('content')
<!-- スクール予約確認画面表示 -->
<div class="reserve_section">
  <div class="reserve_container">
    <div class="calendar_frame">
      <!-- カレンダータイトル -->
      <p class="calendar_title">{{ $calendar->getTitle() }}</p>
      <!-- カレンダー本体 -->
      <div>{!! $calendar->render() !!}</div>
    </div>
  </div>
</div>
@endsection
