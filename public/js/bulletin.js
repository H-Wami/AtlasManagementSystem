$(function () {
  $('.main_categories').click(function () {
    var category_id = $(this).attr('category_id');
    $('.category_num' + category_id).slideToggle();
  });

  $(document).on('click', '.like_btn', function (e) {
    e.preventDefault();
    $(this).addClass('un_like_btn');
    $(this).removeClass('like_btn');
    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text();
    var countInt = Number(count);
    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/like/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'),
      },
    }).done(function (res) {
      console.log(res);
      $('.like_counts' + post_id).text(countInt + 1);
    }).fail(function (res) {
      console.log('fail');
    });
  });

  $(document).on('click', '.un_like_btn', function (e) {
    e.preventDefault();
    $(this).removeClass('un_like_btn');
    $(this).addClass('like_btn');
    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text();
    var countInt = Number(count);

    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/unlike/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'),
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
