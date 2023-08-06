@extends('layouts.sidebar')

@section('content')
<!-- スクール予約画面表示 -->
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <div class="w-75 m-auto border" style="border-radius:5px;">

      <!-- カレンダータイトル -->
      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <!-- カレンダー本体 -->
      <div class="">
        {!! $calendar->render() !!}
      </div>
    </div>
    <!-- 予約ボタン -->
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>
</div>
@endsection
