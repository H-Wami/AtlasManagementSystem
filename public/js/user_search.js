// ユーザー検索機能 追加条件の動き
$(function () {
  $('.search_conditions').click(function () { // 追加条件の追加の文字を押したら
    $('.search_conditions_inner').slideToggle(); // 中身が見える
  });

// ユーザー詳細画面 選択科目の編集の動き
  $('.subject_edit_btn').click(function () { // 選択科目の編集の文字を押したら
    $('.subject_inner').slideToggle(); // 中身が見える
  });
});
