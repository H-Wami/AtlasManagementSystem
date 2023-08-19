@extends('layouts.sidebar')
@section('content')
<div class="vh-100 d-flex">
  <div class="w-50 mt-5">
    <!-- 投稿詳細 -->
    <div class="m-3 detail_container">
      <!-- 投稿編集バリデーションメッセージ -->
      @if($errors->first('post_title'))
      <span class="error_message">{{ $errors->first('post_title') }}</span><br>
      @endif
      @if($errors->first('post_body'))
      <span class="error_message">{{ $errors->first('post_body') }}</span>
      @endif
      <div class="p-3">
        <div class="detail_inner_head">
          <!-- サブカテゴリー -->
          <div>
            <!-- postsテーブルの値->リレーションメソッド->リレーションテーブルの値取得->取得したいカラム名 -->
            <span class="post_sub_category">{{ $post->subCategories->first()->sub_category }}</span>
          </div>
          <!-- もし、投稿のユーザーIDがログインユーザーIDならば表示する -->
          @if($post->user_id === Auth::user()->id)
          <div>
            <!-- 編集ボタン -->
            <span class="edit-modal-open btn btn-primary" post_title="{{ $post->post_title }}" post_body="{{ $post->post }}" post_id="{{ $post->id }}">編集</span>
            <!-- 削除ボタン -->
            <a class="btn btn-danger" href=" {{ route('post.delete', ['id' => $post->id]) }}" class="btn-text" onclick="return confirm('この投稿を削除します。よろしいでしょうか？')">削除</a>
          </div>
          @endif
        </div>

        <div class="contributor d-flex">
          <!-- 投稿者名 -->
          <p>
            <span>{{ $post->user->over_name }}</span>
            <span>{{ $post->user->under_name }}</span>
            さん
          </p>
          <!-- 投稿日時 -->
          <span class="ml-5">{{ $post->created_at }}</span>
        </div>
        <!-- タイトル -->
        <div class="detail_post_title">{{ $post->post_title }}</div>
        <!-- 投稿内容 -->
        <div class="mt-3 detail_post">{{ $post->post }}</div>
      </div>

      <!-- 投稿に対するコメント表示 -->
      <div class="p-3">
        <div class="comment_container">
          <span class="">コメント</span>
          @foreach($post->postComments as $comment)
          <div class="comment_area border-top">
            <!-- コメント投稿者名 -->
            <p>
              <span>{{ $comment->commentUser($comment->user_id)->over_name }}</span>
              <span>{{ $comment->commentUser($comment->user_id)->under_name }}</span>さん
            </p>
            <!-- コメント内容 -->
            <p>{{ $comment->comment }}</p>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  <!-- 新規コメント登録 -->
  <div class="w-50 p-3">
    <div class="comment_container m-5">
      <div class="comment_area p-3">
        <!-- コメントバリデーションメッセージ -->
        @if($errors->first('comment'))
        <span class="error_message">{{ $errors->first('comment') }}</span><br>
        @endif
        <p class="m-0">コメントする</p>
        <!-- コメント入力欄 -->
        <textarea class="w-100" name="comment" form="commentRequest"></textarea>
        <!-- 投稿ボタン -->
        <input type="hidden" name="post_id" form="commentRequest" value="{{ $post->id }}">
        <input type="submit" class="btn btn-primary" form="commentRequest" value="投稿">
        <form action="{{ route('comment.create') }}" method="post" id="commentRequest">{{ csrf_field() }}</form>
      </div>
    </div>
  </div>
</div>

<!-- 編集ボタン モーダル中身 -->
<div class="modal js-modal">
  <div class="modal__bg js-modal-close"></div>
  <div class="modal__content">
    <form action="{{ route('post.edit') }}" method="post">
      <div class="w-100">
        <div class="modal-inner-title w-50 m-auto">
          <input type="text" name="post_title" placeholder="タイトル" class="w-100">
        </div>
        <div class="modal-inner-body w-50 m-auto pt-3 pb-3">
          <textarea placeholder="投稿内容" name="post_body" class="w-100"></textarea>
        </div>
        <div class="w-50 m-auto edit-modal-btn d-flex">
          <a class="js-modal-close btn btn-danger d-inline-block" href="">閉じる</a>
          <input type="hidden" class="edit-modal-hidden" name="post_id" value="">
          <input type="submit" class="btn btn-primary d-block" value="編集">
        </div>
      </div>
      {{ csrf_field() }}
    </form>
  </div>
</div>
@endsection
