$(function () {
  // メインカテゴリーを押した時のサブカテゴリー表示
  $('.main_categories').click(function () {
    var category_id = $(this).attr('category_id'); // 押されたボタンからカテゴリーidを取得して変数へ格納
    $('.category_arrow' + category_id).toggleClass('open'); //矢印の向きが変わる
    $('.category_num' + category_id).slideToggle(); //
  });

  // いいねした時のハートマーク表示機能
  $(document).on('click', '.like_btn', function (e) {
    e.preventDefault(); //like_btnを押したら、(イベントに対するデフォルトの動作をキャンセルする)
    $(this).addClass('un_like_btn'); // un_like_btn表示
    $(this).removeClass('like_btn'); // like_btn非表示
    var post_id = $(this).attr('post_id'); // 押されたボタンから投稿のidを取得し変数へ格納
    var count = $('.like_counts' + post_id).text(); // 文字で表示
    var countInt = Number(count); // 数えた数字を格納
    // 非同期通信
    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post", // メソッド:postで送信
      url: "/like/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'), // 送る値:投稿ID
      },
    }).done(function (res) {
      console.log(res);
      $('.like_counts' + post_id).text(countInt + 1);
    }).fail(function (res) {
      console.log('fail');
    });
  });

  // いいね解除した時のハートマーク表示機能
  $(document).on('click', '.un_like_btn', function (e) {
    e.preventDefault(); //un_like_btnを押したら、(イベントに対するデフォルトの動作をキャンセルする)
    $(this).removeClass('un_like_btn'); // un_like_b非表示
    $(this).addClass('like_btn'); // like_btn表示
    var post_id = $(this).attr('post_id'); // 押されたボタンから投稿のidを取得し変数へ格納
    var count = $('.like_counts' + post_id).text(); // 文字で表示
    var countInt = Number(count);// 数えた数字を格納
    // 非同期通信
    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post", // メソッド:postで送信
      url: "/unlike/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'), // 送る値:投稿ID
      },
    }).done(function (res) {
      $('.like_counts' + post_id).text(countInt - 1);
    }).fail(function () {

    });
  });

  // 投稿編集モーダル機能
  $('.edit-modal-open').on('click', function () { // 編集ボタンを押したら
    $('.js-modal').fadeIn(); // モーダルの中身表示
    var post_title = $(this).attr('post_title'); // 押されたボタンからタイトルを取得し変数へ格納
    var post_body = $(this).attr('post_body'); // 押されたボタンから投稿内容を取得し変数へ格納
    var post_id = $(this).attr('post_id'); // 押されたボタンから投稿のidを取得し変数へ格納
    // （どの投稿を編集するか特定するのに必要な為）
    $('.modal-inner-title input').val(post_title); // 取得したタイトルをモーダルの中身へ渡す
    $('.modal-inner-body textarea').text(post_body); // 取得した投稿内容をモーダルの中身へ渡す
    $('.edit-modal-hidden').val(post_id); // 取得した投稿のidをモーダルの中身へ渡す
    return false;
  });
  $('.js-modal-close').on('click', function () { // 背景部分や閉じるボタンを押したら
    $('.js-modal').fadeOut(); // モーダルの中身非表示
    return false;
  });

});
