<?php
namespace App\Searchs;

use App\Models\Users\User;

class SelectNameDetails implements DisplayUsers{

  // 改修課題：選択科目の検索機能
  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    if(is_null($gender)){ // もし性別の値が空ならば
      $gender = ['1', '2', '3'];
    }else{ // それ以外ならば(値があれば)
      $gender = array($gender); // 配列に変換
    }
    if(is_null($role)){ // もし権限の値が空ならば
      $role = ['1', '2', '3', '4', '5'];
    }else{ // それ以外ならば(値があれば)
      $role = array($role); // 配列に変換
    }
    $users = User::with('subjects') // Userモデルと関連するsubjectsテーブルを取得
    ->where(function($q) use ($keyword){
      $q->Where('over_name', 'like', '%'.$keyword.'%') // 姓であいまい検索
      ->orWhere('under_name', 'like', '%'.$keyword.'%') // または名であいまい検索
      ->orWhere('over_name_kana', 'like', '%'.$keyword.'%') // または姓のフリガナであいまい検索
      ->orWhere('under_name_kana', 'like', '%'.$keyword.'%'); // または名のフリガナであいまい検索
    })
    ->where(function($q) use ($role, $gender){
      $q->whereIn('sex', $gender) // usersテーブルのsexカラムが$genderと同じ
      ->whereIn('role', $role); // usersテーブルのroleカラムが$roleと同じ
    })
    ->whereHas('subjects', function($q) use ($subjects){ // リレーション先のsubjectsの条件で検索
      $q->whereIn('subjects.id', $subjects); // idカラムと$subjectsが同じ whereからwhereInに変更(複数の値で検索する為)
    })
    ->orderBy('over_name_kana', $updown)->get(); // 姓の$updown(昇順か降順)で値を取得する
    return $users;
  }

}
