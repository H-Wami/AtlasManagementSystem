@extends('layouts.sidebar')

@section('content')
<p>ユーザー検索</p>
<div class="search_content w-100 border d-flex">
  <!-- ユーザー一覧 -->
  <div class="reserve_users_area">
    @foreach($users as $user)
    <!-- ユーザー情報ひとまとめ -->
    <div class="border one_person">
      <div>
        <span>ID : </span><span>{{ $user->id }}</span>
      </div>
      <div><span>名前 : </span>
        <!-- ユーザー情報詳細画面に移動 -->
        <a href="{{ route('user.profile', ['id' => $user->id]) }}">
          <span>{{ $user->over_name }}</span>
          <span>{{ $user->under_name }}</span>
        </a>
      </div>
      <div>
        <span>カナ : </span>
        <span>({{ $user->over_name_kana }}</span>
        <span>{{ $user->under_name_kana }})</span>
      </div>
      <div>
        <!-- もし、性別の値が1ならば男を表示する -->
        @if($user->sex == 1)
        <span>性別 : </span><span>男</span>
        <!-- もし、性別の値が2ならば女を表示する -->
        @elseif($user->sex == 2)
        <span>性別 : </span><span>女</span>
        <!-- それ以外の値(3)ならばその他を表示する 追加 -->
        @else
        <span>性別 : </span><span>その他</span>
        @endif
      </div>
      <div>
        <span>生年月日 : </span><span>{{ $user->birth_day }}</span>
      </div>
      <div>
        <!-- もし、権限の値が1ならば教師(国語)を表示する -->
        @if($user->role == 1)
        <span>権限 : </span><span>教師(国語)</span>
        <!-- もし、権限の値が2ならば教師(数学)を表示する -->
        @elseif($user->role == 2)
        <span>権限 : </span><span>教師(数学)</span>
        <!-- もし、権限の値が3ならば教師(英語)を表示する -->
        @elseif($user->role == 3)
        <span>権限 : </span><span>教師(英語)</span>
        @else
        <!-- それ以外ならば(4)生徒を表示する -->
        <span>権限 : </span><span>生徒</span>
        @endif
      </div>
      <div>
        <!-- もし権限が4(生徒)だったら選択科目を表示 -->
        @if($user->role == 4)
        <span>選択科目 :</span>
        <!-- ユーザーに紐付いている選択科目(教科)を持ってくる $紐付いている元->リレーションメソッド -->
        @foreach($user->subjects as $subject)
        <span>{{ $subject->subject }}</span>
        @endforeach
        @endif
      </div>
    </div>
    @endforeach
  </div>
  <!-- ユーザー検索 -->
  <div class="search_area w-25 border">
    <div class="">
      <!-- キーワード検索フォーム -->
      <div>
        <input type="text" class="free_word" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
      </div>
      <div>
        <label>カテゴリ</label>
        <select form="userSearchRequest" name="category">
          <option value="name">名前</option>
          <option value="id">社員ID</option>
        </select>
      </div>
      <div>
        <label>並び替え</label>
        <select name="updown" form="userSearchRequest">
          <option value="ASC">昇順</option>
          <option value="DESC">降順</option>
        </select>
      </div>
      <!-- クリックすると追加条件を表示 -->
      <div class="">
        <p class="m-0 search_conditions"><span>検索条件の追加</span></p>
        <!-- 追加条件の中身 -->
        <div class="search_conditions_inner">
          <div>
            <label>性別</label>
            <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
            <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
            <!-- その他追加 -->
            <span>その他</span><input type="radio" name="sex" value="3" form="userSearchRequest">
          </div>
          <div>
            <label>権限</label>
            <select name="role" form="userSearchRequest" class="engineer">
              <option selected disabled>----</option>
              <option value="1">教師(国語)</option>
              <option value="2">教師(数学)</option>
              <option value="3">教師(英語)</option>
              <option value="4" class="">生徒</option>
            </select>
          </div>
          <div class="selected_engineer">
            <label>選択科目</label>
            @foreach($subjects as $subject)
            <!-- 選択科目追加(新規登録画面参照) -->
            <div class="">
              <input type="checkbox" name="subject[]" value="{{ $subject->id }}" form="userSearchRequest">
              <label>{{ $subject->subject }}</label>
            </div>
            @endforeach
          </div>
        </div>
      </div>
      <!-- リセットボタン -->
      <div>
        <input type="reset" value="リセット" form="userSearchRequest">
      </div>
      <!-- 検索ボタン -->
      <div>
        <input type="submit" name="search_btn" value="検索" form="userSearchRequest">
      </div>
    </div>
    <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
  </div>
</div>
@endsection
