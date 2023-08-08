$(function () {

  // 予約削除モーダル機能
  $('.reserve-modal-open').on('click', function () { // 編集ボタンを押したら
    $('.js-modal').fadeIn(); // モーダルの中身表示
    // var post_title = $(this).attr('post_title'); // 押されたボタンからタイトルを取得し変数へ格納
    // var post_body = $(this).attr('post_body'); // 押されたボタンから投稿内容を取得し変数へ格納
    // var post_id = $(this).attr('post_id'); // 押されたボタンから投稿のidを取得し変数へ格納
    // // （どの投稿を編集するか特定するのに必要な為）
    // $('.modal-inner-title input').val(post_title); // 取得したタイトルをモーダルの中身へ渡す
    // $('.modal-inner-body textarea').text(post_body); // 取得した投稿内容をモーダルの中身へ渡す
    // $('.edit-modal-hidden').val(post_id); // 取得した投稿のidをモーダルの中身へ渡す
    return false;
  });
  $('.js-modal-close').on('click', function () { // 背景部分や閉じるボタンを押したら
    $('.js-modal').fadeOut(); // モーダルの中身非表示
    return false;
  });

});
