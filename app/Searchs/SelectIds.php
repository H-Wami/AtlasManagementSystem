<?php
namespace App\Searchs;

use App\Models\Users\User;

class SelectIds implements DisplayUsers{

  // 改修課題：選択科目の検索機能
  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    if(is_null($gender)){ // もし性別の値が空ならば
      $gender = ['1', '2', '3'];
    }else{ // それ以外ならば(値があれば)
      $gender = array($gender); // 配列に変換
    }
    if(is_null($role)){ // もし権限の値が空ならば
      $role = ['1', '2', '3', '4'];
    }else{ // それ以外ならば(値があれば)
      $role = array($role); // 配列に変換
    }

    if(is_null($keyword)){ // もし検索ワードの値が空ならば
      $users = User::with('subjects')// Userモデルと関連するsubjectsテーブルを取得
      ->whereIn('sex', $gender) // usersテーブルのsexカラムが$genderと同じ
      ->whereIn('role', $role) // usersテーブルのroleカラムが$roleと同じ
      ->orderBy('id', $updown)->get(); // idの$updown(昇順か降順)で値を取得する
    }else{ // それ以外ならば(値があれば)
      $users = User::with('subjects') // Userモデルと関連するsubjectsテーブルを取得
      ->where('id', $keyword) // usersテーブルのidカラムが$keywordと同じ
      ->whereIn('sex', $gender) // usersテーブルのsexカラムが$genderと同じ
      ->whereIn('role', $role) // usersテーブルのroleカラムが$roleと同じ
      ->orderBy('id', $updown)->get(); // idの$updown(昇順か降順)で値を取得する
    }
    return $users;
  }

}
