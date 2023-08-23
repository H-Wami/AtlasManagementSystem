@extends('layouts.sidebar')

@section('content')
<!-- スクール予約画面表示 -->
<div class="reserve_section">
  <div class="reserve_container">
    <div class="calendar_frame">
      <!-- カレンダータイトル -->
      <p class="calendar_title">{{ $calendar->getTitle() }}</p>
      <!-- カレンダー本体 -->
      <div class="">
        {!! $calendar->render() !!}
      </div>
    </div>
    <!-- 予約ボタン -->
    <div class="reserve_btn">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>
</div>

<!-- 予約削除モーダル中身 -->
<div class="modal js-modal">
  <div class="modal__bg js-modal-close"></div>
  <div class="modal__content">
    <div class="reserve_modal_content">
      <span class="modal_text">予約日:
        <span class="reserve_day"></span>
      </span>
      <span class="modal_text">時間:リモ
        <span class="reserve_part"></span>部
      </span>
      <span class="modal_text">上記の予約をキャンセルしてもよろしいですか？</span>
      <!-- ボタンひとまとめ -->
      <div class="modal_btn_contents">
        <a class="js-modal-close btn btn-primary" href="">閉じる</a>
        <input type="submit" class="btn btn-danger" value="キャンセル" form="deleteParts">
        <input type="hidden" class="reserve_modal_hidden" name="id" form="deleteParts" value="">
      </div>
    </div>
  </div>
</div>
@endsection
