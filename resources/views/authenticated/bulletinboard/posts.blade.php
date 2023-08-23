@extends('layouts.sidebar')

@section('content')
<div class="board_area w-100 m-auto d-flex">
  <!-- 投稿一覧 -->
  <div class="post_view">
    @foreach($posts as $post)
    <!-- 投稿ひとまとめ -->
    <div class="post_area w-75 p-3">
      <!-- 投稿者名 -->
      <p class="contributor"><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <!-- タイトル -->
      <p><a href="{{ route('post.detail', ['id' => $post->id]) }}" class="post_title">{{ $post->post_title }}</a></p>
      <!-- 下端コンテンツひとまとめ -->
      <div class="post_bottom_area d-flex">
        <!-- サブカテゴリー -->
        <div>
          <!-- postsテーブルの値->リレーションメソッド->リレーションテーブルの値取得->取得したいカラム名 -->
          <span class="post_sub_category">{{ $post->subCategories->first()->sub_category }}</span>
        </div>
        <div class="d-flex post_status">
          <!-- コメント吹き出し -->
          <div class="mr-5">
            <i class="fa fa-comment"></i><span class="post_counts">{{ $post->commentCounts($post->id)->count() }}</span><!-- $postの値取得->commentCountsメソッド使用->count関数で各投稿のコメントの数を取得 -->
          </div>
          <!-- いいねハートマーク -->
          <div class="">
            <!-- もし、ログインユーザーがいいねしていたら、いいね解除マークを表示する -->
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id}}">{{ $like->likeCounts($post->id) }}</span></p><!-- モデルをインスタンス化->likeCountsメソッドで各投稿のいいねの数を取得。 -->
            <!-- いいねしていなければ、いいね実行マークを表示する -->
            @else
            <p class="m-0"><i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span></p><!-- モデルをインスタンス化->likeCountsメソッドで各投稿のいいねの数を取得。 -->
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area">
    <!-- 新規投稿ボタン -->
    <div class="">
      <input type="submit" name="posts_create" class="post_btn" value="投稿" form="postCreate">
      <form action="{{ route('post.input') }}" method="get" id="postCreate"></form>
    </div>
    <!-- 検索フォーム -->
    <div class="post_search_box">
      <input type="text" placeholder="キーワードを検索" name="keyword" class="post_search_form" form="postSearchRequest">
      <input type="submit" value="検索" form="postSearchRequest" class="post_search_btn">
    </div>
    <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
    <div class="search_btn_group">
      <!-- いいねした投稿表示ボタン -->
      <input type="submit" name="like_posts" class="like_post_btn" value="いいねした投稿" form="likeSearchRequest">
      <form action="{{ route('post.show') }}" method="get" id="likeSearchRequest"></form>
      <!-- 自分の投稿表示ボタン -->
      <input type="submit" name="my_posts" class="my_post_btn" value="自分の投稿" form="mySearchRequest">
      <form action="{{ route('post.show') }}" method="get" id="mySearchRequest"></form>
    </div>
    <!-- カテゴリー検索 -->
    <label class="select_text">カテゴリー検索</label>
    <!-- カテゴリーひとまとめ -->
    <ul>
      <!-- メインカテゴリー表示 -->
      @foreach($categories as $category)
      <li class="main_categories" category_id="{{ $category->id }}">
        <div class="main_category_contents">
          <span>{{ $category->main_category }}</span><span class="category_arrow{{ $category->id}}"></span>
        </div>
        <!-- サブカテゴリー表示 -->
        <div class="category_num{{ $category->id }}">
          <!-- メインカテゴリーに紐付いているサブカテゴリーを持ってくる $紐付いている元->リレーションメソッド -->
          @foreach($category->subCategories as $sub_category)
          <input type="submit" name="category_word" class="category_btn" value="{{ $sub_category->sub_category }}" form="postSearchRequest">
          @endforeach
        </div>
      </li>
      @endforeach
    </ul>
  </div>
</div>
@endsection
