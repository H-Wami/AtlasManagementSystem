@extends('layouts.sidebar')

@section('content')
<div class="board_area w-100 border m-auto d-flex">
  <!-- 投稿一覧 -->
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto">投稿一覧</p>
    @foreach($posts as $post)
    <!-- 投稿ひとまとめ -->
    <div class="post_area border w-75 m-auto p-3">
      <!-- 投稿者名 -->
      <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <!-- タイトル -->
      <p><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
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
            <i class="fa fa-comment"></i><span class=""></span>
          </div>
          <!-- いいねハートマーク -->
          <div>
            <!-- もし、ログインユーザーがいいねしていたら、いいね解除マークを表示する -->
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span></p><!-- モデルをインスタンス化->likeCountsメソッドで各投稿のいいねの数を取得。 -->
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
  <div class="other_area border w-25">
    <div class="border m-4">
      <div class=""><a href="{{ route('post.input') }}">投稿</a></div>
      <div class="">
        <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="submit" value="検索" form="postSearchRequest">
      </div>
      <!-- いいねした投稿表示ボタン -->
      <input type="submit" name="like_posts" class="category_btn" value="いいねした投稿" form="postSearchRequest">
      <!-- 自分の投稿表示ボタン -->
      <input type="submit" name="my_posts" class="category_btn" value="自分の投稿" form="postSearchRequest">
      <ul>
        @foreach($categories as $category)
        <li class="main_categories" category_id="{{ $category->id }}"><span>{{ $category->main_category }}<span></li>
        @endforeach
      </ul>
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>
@endsection
