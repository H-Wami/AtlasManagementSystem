@extends('layouts.sidebar')

@section('content')
<div class="search_content">
  <!-- ユーザー一覧 -->
  <div class="reserve_users_area">
    @foreach($users as $user)
    <!-- ユーザー情報ひとまとめ -->
    <div class="one_person">
      <div>
        <span class="user_item">ID : </span><span class="user_info">{{ $user->id }}</span>
      </div>
      <div><span class="user_item">名前 : </span>
        <!-- ユーザー情報詳細画面に移動 -->
        <a class="user_name" href="{{ route('user.profile', ['id' => $user->id]) }}">
          <span class="user_info">{{ $user->over_name }}</span>
          <span class="user_info">{{ $user->under_name }}</span>
        </a>
      </div>
      <div>
        <span class="user_item">カナ : </span>
        <span class="user_info">({{ $user->over_name_kana }}</span>
        <span class="user_info">{{ $user->under_name_kana }})</span>
      </div>
      <div>
        <!-- もし、性別の値が1ならば男を表示する -->
        @if($user->sex == 1)
        <span class="user_item">性別 : </span>
        <span class="user_info">男</span>
        <!-- もし、性別の値が2ならば女を表示する -->
        @elseif($user->sex == 2)
        <span class="user_item">性別 : </span>
        <span class="user_info">女</span>
        <!-- それ以外の値(3)ならばその他を表示する 追加 -->
        @else
        <span class="user_item">性別 : </span>
        <span class="user_info">その他</span>
        @endif
      </div>
      <div>
        <span class="user_item">生年月日 : </span>
        <span class="user_info">{{ $user->birth_day }}</span>
      </div>
      <div>
        <!-- もし、権限の値が1ならば教師(国語)を表示する -->
        @if($user->role == 1)
        <span class="user_item">権限 : </span>
        <span class="user_info">教師(国語)</span>
        <!-- もし、権限の値が2ならば教師(数学)を表示する -->
        @elseif($user->role == 2)
        <span class="user_item">権限 : </span>
        <span class="user_info">教師(数学)</span>
        <!-- もし、権限の値が3ならば教師(英語)を表示する -->
        @elseif($user->role == 3)
        <span class="user_item">権限 : </span>
        <span class="user_info">教師(英語)</span>
        @else
        <!-- それ以外ならば(4)生徒を表示する -->
        <span class="user_item">権限 : </span>
        <span class="user_info">生徒</span>
        @endif
      </div>
      <div>
        <!-- もし権限が4(生徒)だったら選択科目を表示 -->
        @if($user->role == 4)
        <span class="user_item">選択科目 :</span>
        <!-- ユーザーに紐付いている選択科目(教科)を持ってくる $紐付いている元->リレーションメソッド -->
        @foreach($user->subjects as $subject)
        <span class="user_info">{{ $subject->subject }}</span>
        @endforeach
        @endif
      </div>
    </div>
    @endforeach
  </div>
  <!-- ユーザー検索 -->
  <div class="search_area w-25">
    <div class="search_users_area">
      <!-- キーワード検索フォーム -->
      <div class="search_items">
        <label class="search_text">検索</label>
        <input type="text" class="free_word" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
      </div>
      <div class="search_items">
        <label class="select_text">カテゴリ</label>
        <select form="userSearchRequest" name="category" class="select_item">
          <option value="name">名前</option>
          <option value="id">社員ID</option>
        </select>
      </div>
      <div class="search_items">
        <label class="select_text">並び替え</label>
        <select name="updown" form="userSearchRequest" class="select_item">
          <option value="ASC">昇順</option>
          <option value="DESC">降順</option>
        </select>
      </div>
      <!-- クリックすると追加条件を表示 -->
      <div class="">
        <p class="m-0 search_conditions"><span>検索条件の追加</span><span class="arrow navy"></span></p>
        <!-- 追加条件の中身 -->
        <div class="search_conditions_inner">
          <label class="select_text">性別</label>
          <div class="inner_items">
            <div class="select_content"><span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest"></div>
            <div class="select_content"><span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest"></div>
            <!-- その他追加 -->
            <div class="select_content"><span>その他</span><input type="radio" name="sex" value="3" form="userSearchRequest"></div>
          </div>
          <label class="select_text">権限</label>
          <div class="inner_items">
            <select name="role" form="userSearchRequest" class="select_item">
              <option selected disabled>----</option>
              <option value="1">教師(国語)</option>
              <option value="2">教師(数学)</option>
              <option value="3">教師(英語)</option>
              <option value="4" class="">生徒</option>
            </select>
          </div>
          <label class="select_text">選択科目</label>
          <div class="inner_items">
            @foreach($subjects as $subject)
            <!-- 選択科目追加(新規登録画面参照) -->
            <div class="select_content">
              <label>{{ $subject->subject }}</label>
              <input type="checkbox" name="subject[]" value="{{ $subject->id }}" form="userSearchRequest">
            </div>
            @endforeach
          </div>
        </div>
      </div>
      <!-- 検索ボタン -->
      <div class="search_items">
        <input type="submit" name="search_btn" value="検索" form="userSearchRequest" class="search_btn">
      </div>
      <!-- リセットテキスト -->
      <div class="search_items">
        <input type="reset" value="リセット" form="userSearchRequest" class="reset_text">
      </div>
    </div>
    <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
  </div>
</div>
@endsection
