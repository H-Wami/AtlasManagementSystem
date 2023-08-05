@extends('layouts.sidebar')

@section('content')
<div class="vh-100 border">
  <div class="top_area w-75 m-auto pt-5">
    <p>マイページ</p>
    <div class="user_status p-3">
      <p>名前：<span>{{ Auth::user()->over_name }}</span><span class="ml-1">{{ Auth::user()->under_name }}</span></p>
      <p>カナ：<span>{{ Auth::user()->over_name_kana }}</span><span class="ml-1">{{ Auth::user()->under_name_kana }}</span></p>
      <p>性別 :
        <!-- もし、性別の値が1ならば男を表示する -->
        @if(Auth::user()->sex == 1)
        <span>男</span>
        <!-- もし、性別の値が2ならば女を表示する -->
        @elseif(Auth::user()->sex == 2)
        <span>女</span>
        <!-- それ以外の値(3)ならばその他を表示する 追加 -->
        @else
        <span>その他</span>
        @endif
      <p>生年月日：<span>{{ Auth::user()->birth_day }}</span></p>
    </div>
  </div>
</div>
@endsection
