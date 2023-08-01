@extends('layouts.sidebar')

@section('content')

<div class="post_view w-75 mt-5">
  <p class="w-75 m-auto">自分の投稿</p>
  @foreach($posts as $post)
  <div class="post_area border w-75 m-auto p-3">
    <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
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
          <i class="fa fa-comment"></i><span class="">{{ $post->commentCounts($post->id)->count() }}</span><!-- $postの値取得->commentCountsメソッド使用->count関数で各投稿のコメントの数を取得 -->
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

@endsection
