@extends('layouts.sidebar')

@section('content')
<p class="subtitle">{{ $user->over_name }}{{ $user->under_name }}さんのプロフィール</p>
<div class="vh-100">
  <div class="top_area w-75 m-auto pt-5">
    <div class="user_status p-3">
      <p>名前 : <span>{{ $user->over_name }}</span>
        <span class="ml-1">{{ $user->under_name }}</span>
      </p>
      <p>カナ : <span>{{ $user->over_name_kana }}</span>
        <span class="ml-1">{{ $user->under_name_kana }}</span>
      </p>
      <p>性別 :
        <!-- もし、性別の値が1ならば男を表示する -->
        @if($user->sex == 1)
        <span>男</span>
        <!-- もし、性別の値が2ならば女を表示する -->
        @elseif($user->sex == 2)
        <span>女</span>
        <!-- それ以外の値(3)ならばその他を表示する 追加 -->
        @else
        <span>その他</span>
        @endif
      <p>生年月日 : <span>{{ $user->birth_day }}</span></p>
      <div>選択科目 :
        @foreach($user->subjects as $subject)
        <span>{{ $subject->subject }}</span>
        @endforeach
      </div>
      <div>
        <!-- もし、ログインユーザーの権限が生徒以外(講師)ならば表示する -->
        @can('admin')
        <!-- クリックすると選択科目を表示 -->
        <span class="subject_edit_btn">選択科目の登録</span>
        <span class="arrow"></span>
        <!-- 選択科目の登録の中身 -->
        <div class="subject_inner">
          <form action="{{ route('user.edit') }}" method="post">
            <div class="subject_list">
              @foreach($subject_lists as $subject_list)
              <label>{{ $subject_list->subject }}</label>
              <input type="checkbox" name="subjects[]" value="{{ $subject_list->id }}">
              @endforeach
              <input type="submit" value="登録" class="btn btn-primary">
              <input type="hidden" name="user_id" value="{{ $user->id }}">
              {{ csrf_field() }}
            </div>
          </form>
        </div>
        @endcan
      </div>
    </div>
  </div>
</div>

@endsection
