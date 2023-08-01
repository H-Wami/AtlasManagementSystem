@extends('layouts.sidebar')

@section('content')
<!-- フォーム位置修正 -->
<form action="{{ route('post.create') }}" method="post" id="postCreate">
  {{ csrf_field() }}
  <div class="post_create_container d-flex">
    <div class="post_create_area border w-50 m-5 p-5">
      <!-- カテゴリー -->
      <div class="">
        @if($errors->has('post_category_id'))
        @foreach($errors->get('post_category_id') as $message)
        <span class="error_message">{{ $message }}</span><br>
        @endforeach
        @endif
        <p class="mb-0">カテゴリー</p>
        <select class="w-100" form="postCreate" name="post_category_id">
          <!-- メインカテゴリー表示 -->
          @foreach($main_categories as $main_category)
          <optgroup label="{{ $main_category->main_category }}"></optgroup>
          <!-- サブカテゴリー表示 -->
          <!-- メインカテゴリーに紐付いているサブカテゴリーを持ってくる $紐付いている元->リレーションメソッド -->
          @foreach($main_category->subCategories as $sub_category)
          <option value="{{ $sub_category->id }}">{{ $sub_category->sub_category }}</option>
          @endforeach
          </optgroup>
          @endforeach
        </select>
      </div>
      <!-- タイトル -->
      <div class="mt-3">
        @if($errors->first('post_title'))
        <span class="error_message">{{ $errors->first('post_title') }}</span>
        @endif
        <p class="mb-0">タイトル</p>
        <input type="text" class="w-100" form="postCreate" name="post_title" value="{{ old('post_title') }}">
        <!-- oldヘルパー:バリデーションエラーになった場合に、フォームの値を保持 -->
      </div>
      <!-- 投稿内容 -->
      <div class="mt-3">
        @if($errors->first('post_body'))
        <span class="error_message">{{ $errors->first('post_body') }}</span>
        @endif
        <p class="mb-0">投稿内容</p>
        <textarea class="w-100" form="postCreate" name="post_body">{{ old('post_body') }}</textarea>
      </div>
      <!-- 投稿ボタン -->
      <div class="mt-3 text-right">
        <input type="submit" class="btn btn-primary" value="投稿" form="postCreate">
      </div>
</form>
</div>
<!-- 講師のみ表示 -->
@can('admin')
<div class="w-25 ml-auto mr-auto">
  <div class="category_area mt-5 p-5">
    <!-- メインカテゴリーバリデーションメッセージ -->
    @if($errors->has('main_category_name'))
    @foreach($errors->get('main_category_name') as $message)
    <span class="error_message">{{ $message }}</span><br>
    @endforeach
    @endif
    <!-- メインカテゴリー追加 -->
    <div class="category_container">
      <p class="m-0">メインカテゴリー</p>
      <!-- メインカテゴリー入力フォーム -->
      <input type="text" class="w-100" name="main_category_name" form="mainCategoryRequest">
      <!-- 追加ボタン -->
      <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="mainCategoryRequest">
    </div>
    <form action="{{ route('main.category.create') }}" method="post" id="mainCategoryRequest">{{ csrf_field() }}</form>
    <!-- サブカテゴリー追加 -->
    <div class="category_container">
      <!-- メインカテゴリー選択バリデーションメッセージ -->
      @if($errors->has('main_category_id'))
      @foreach($errors->get('main_category_id') as $message)
      <span class="error_message">{{ $message }}</span><br>
      @endforeach
      @endif
      <p class="m-0">サブカテゴリー</p>
      <!-- メインカテゴリー選択フォーム -->
      <select class="w-100" form="subCategoryRequest" name="main_category_id">
        <option value="none">---</option>
        @foreach($main_categories as $main_category)
        <option value="{{ $main_category->id }}">{{ $main_category->main_category }}</option>
        @endforeach
      </select>
      <!-- サブカテゴリーバリデーションメッセージ -->
      @if($errors->has('sub_category_name'))
      @foreach($errors->get('sub_category_name') as $message)
      <span class="error_message">{{ $message }}</span><br>
      @endforeach
      @endif
      <!-- サブカテゴリー入力フォーム -->
      <input type="text" class="w-100" name="sub_category_name" form="subCategoryRequest">
      <!-- 追加ボタン -->
      <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="subCategoryRequest">
    </div>
    <form action="{{ route('sub.category.create') }}" method="post" id="subCategoryRequest">{{ csrf_field() }}</form>
  </div>
</div>
@endcan
</div>
@endsection
