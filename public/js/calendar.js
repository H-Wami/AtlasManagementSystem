$(function () {

  // 予約削除モーダル機能
  $('.reserve-modal-open').on('click', function () { // 編集ボタンを押したら
    $('.js-modal').fadeIn(); // モーダルの中身表示
    var setting_reserve = $(this).attr('setting_reserve'); // 押されたボタンから開講日を取得し変数へ格納
    var setting_part = $(this).attr('setting_part'); // 押されたボタンから部を取得し変数へ格納
    var id = $(this).attr('id'); // 押されたボタンからidを取得し変数へ格納
    // （どの予約をキャンセルするか特定するのに必要な為）
    $('.reserve_day').text(setting_reserve); // 取得した開講日をモーダルの中身へ渡す
    $('.reserve_part').text(setting_part); // 取得した部をモーダルの中身へ渡す
    $('.reserve_modal_hidden').val(id); // 取得したidをモーダルの中身へ渡す
    return false;
  });
  $('.js-modal-close').on('click', function () { // 背景部分や閉じるボタンを押したら
    $('.js-modal').fadeOut(); // モーダルの中身非表示
    return false;
  });

});
