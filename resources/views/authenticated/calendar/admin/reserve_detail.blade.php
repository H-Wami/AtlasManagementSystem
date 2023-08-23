@extends('layouts.sidebar')

@section('content')
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-75 m-auto h-75">
    <!-- 日付・部 -->
    <p><span>{{ $date }}日</span><span class="ml-3">{{ $part }}部</span></p>
    <div class="user_status">
      <table class="reserve_table">
        <!-- 表の項目 theadタグで囲む -->
        <thead>
          <tr class="table_items">
            <th class="user_id_item">ID</th>
            <th class="user_info_item">名前</th>
            <th class="user_info_item">場所</th>
          </tr>
        </thead>
        <!-- 予約ユーザーひとまとめ tbodyタグで囲む(foreachもまとめて) -->
        <tbody>
          @foreach($reservePersons as $reservePerson)
          @foreach($reservePerson->users as $user)
          <tr class="table_user">
            <td class="user_id_item">{{ $user->id }}</td>
            <td class="user_info_item">{{ $user->over_name.$user->under_name }}</td>
            <td class="user_info_item">リモート</td>
          </tr>
          @endforeach
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
