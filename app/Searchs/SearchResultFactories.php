<?php
namespace App\Searchs;

use App\Models\Users\User;

class SearchResultFactories{

  // 改修課題：選択科目の検索機能
  public function initializeUsers($keyword, $category, $updown, $gender, $role, $subjects){
    if($category == 'name'){ //もしカテゴリーが名前ならば
      if(is_null($subjects)){ // もし$subjectsの値がなければ
        $searchResults = new SelectNames(); // SelectNamesモデル使用(値の取り出し)
      }else{ // それ以外ならば($subjectsの値があれば)
        $searchResults = new SelectNameDetails(); // SelectNameDetailsモデル使用(値の取り出し)
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    }else if($category == 'id'){ //もしカテゴリーが社員IDならば
      if(is_null($subjects)){ // もし$subjectsの値がなければ
        $searchResults = new SelectIds(); // SelectIdsモデル使用(値の取り出し)
      }else{ // それ以外ならば($subjectsの値があれば)
        $searchResults = new SelectIdDetails(); // SelectIdDetailsモデル使用(値の取り出し)
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    }else{ // それ以外ならば
      $allUsers = new AllUsers(); // AllUsersモデル使用(値の取り出し)
    return $allUsers->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    }
  }
}
