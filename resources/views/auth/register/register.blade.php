<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AtlasBulletinBoard</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
  <!-- bootstrap読み込み -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <!-- リセット.CSS(ress.css)読み込み -->
  <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&family=Oswald:wght@200&display=swap" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>

<body class="all_content">
  <form action="{{ route('registerPost') }}" method="POST">
    <div class="register_container">
      <div class="register_form">
        <!-- 姓・名バリデーションメッセージ -->
        @if($errors->has('over_name'))
        <span class="error_message">{{ $errors->first('over_name') }}</span><br>
        @endif
        @if($errors->has('under_name'))
        <span class="error_message">{{ $errors->first('under_name') }}</span>
        @endif
        <div class="d-flex mt-3 " style="justify-content:space-between">
          <div class="" style="width:140px">
            <label class="d-block m-0" style="font-size:13px">姓</label>
            <div class="border-bottom border-primary" style="width:140px;">
              <input type="text" style="width:140px;" class="border-0 over_name" name="over_name">
            </div>
          </div>
          <div class="" style="width:140px">
            <label class=" d-block m-0" style="font-size:13px">名</label>
            <div class="border-bottom border-primary" style="width:140px;">
              <input type="text" style="width:140px;" class="border-0 under_name" name="under_name">
            </div>
          </div>
        </div>
        <!-- セイ・メイバリデーションメッセージ -->
        @if($errors->has('over_name_kana'))
        @foreach($errors->get('over_name_kana') as $message)
        <span class="error_message">{{ $message }}</span><br>
        @endforeach
        @endif
        @if($errors->has('under_name_kana'))
        @foreach($errors->get('under_name_kana') as $message)
        <span class="error_message">{{ $message }}</span><br>
        @endforeach
        @endif
        <div class="d-flex mt-3" style="justify-content:space-between">
          <div class="" style="width:140px">
            <label class="d-block m-0" style="font-size:13px">セイ</label>
            <div class="border-bottom border-primary" style="width:140px;">
              <input type="text" style="width:140px;" class="border-0 over_name_kana" name="over_name_kana">
            </div>
          </div>
          <div class="" style="width:140px">
            <label class="d-block m-0" style="font-size:13px">メイ</label>
            <div class="border-bottom border-primary" style="width:140px;">
              <input type="text" style="width:140px;" class="border-0 under_name_kana" name="under_name_kana">
            </div>
          </div>
        </div>
        <!-- メールアドレスバリデーションメッセージ -->
        @if($errors->has('mail_address'))
        @foreach($errors->get('mail_address') as $message)
        <span class="error_message">{{ $message }}</span><br>
        @endforeach
        @endif
        <div class="mt-3">
          <label class="m-0 d-block" style="font-size:13px">メールアドレス</label>
          <div class="border-bottom border-primary">
            <input type="mail" class="w-100 border-0 mail_address" name="mail_address">
          </div>
        </div>
        <!-- 性別:ラジオボタン -->
        <div class="sex_contents">
          <label style="font-size:13px">
            <input type="radio" name="sex" class="sex radio" value="1">男性
          </label>
          <label style="font-size:13px">
            <input type="radio" name="sex" class="sex radio" value="2">女性
          </label>
          <label style="font-size:13px">
            <input type="radio" name="sex" class="sex radio" value="3">その他
          </label>
        </div>
        <!-- 生年月日 バリデーションメッセージ -->
        @if($errors->has('birth_day'))
        @foreach($errors->get('birth_day') as $message)
        <span class="error_message">{{ $message }}</span><br>
        @endforeach
        @endif
        <div class="mt-3">
          <label class="d-block m-0 aa" style="font-size:13px">生年月日</label>
          <div class="select_contents">
            <select class="old_year birth_day" name="old_year">
              <!-- バリデーションルール2000年~に修正 -->
              <option value="none">-----</option>
              <option value="2000">2000</option>
              <option value="2001">2001</option>
              <option value="2002">2002</option>
              <option value="2003">2003</option>
              <option value="2004">2004</option>
              <option value="2005">2005</option>
              <option value="2006">2006</option>
              <option value="2007">2007</option>
              <option value="2008">2008</option>
              <option value="2009">2009</option>
              <option value="2010">2010</option>
              <option value="2011">2011</option>
              <option value="2012">2012</option>
              <option value="2013">2013</option>
              <option value="2014">2014</option>
              <option value="2015">2015</option>
              <option value="2016">2016</option>
              <option value="2017">2017</option>
              <option value="2018">2018</option>
              <option value="2019">2019</option>
              <option value="2020">2020</option>
              <option value="2021">2021</option>
              <option value="2022">2022</option>
              <option value="2023">2023</option>
            </select>
            <label class="birth_day_text">年</label>
            <select class="old_month birth_day" name="old_month">
              <option value="none">-----</option>
              <option value="01">1</option>
              <option value="02">2</option>
              <option value="03">3</option>
              <option value="04">4</option>
              <option value="05">5</option>
              <option value="06">6</option>
              <option value="07">7</option>
              <option value="08">8</option>
              <option value="09">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
            </select>
            <label class="birth_day_text">月</label>
            <select class="old_day birth_day" name="old_day">
              <option value="none">-----</option>
              <option value="01">1</option>
              <option value="02">2</option>
              <option value="03">3</option>
              <option value="04">4</option>
              <option value="05">5</option>
              <option value="06">6</option>
              <option value="07">7</option>
              <option value="08">8</option>
              <option value="09">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">22</option>
              <option value="23">23</option>
              <option value="24">24</option>
              <option value="25">25</option>
              <option value="26">26</option>
              <option value="27">27</option>
              <option value="28">28</option>
              <option value="29">29</option>
              <option value="30">30</option>
              <option value="31">31</option>
            </select>
            <label class="birth_day_text">日</label>
          </div>
        </div>
        <!-- 役職:ラジオボタン -->
        <div class="mt-3">
          <label class="d-block m-0" style="font-size:13px">役職</label>
          <div class="select_contents">
            <label style="font-size:13px">
              <input type="radio" name="role" class="admin_role role radio" value="1">教師(国語)
            </label>
            <label style="font-size:13px">
              <input type="radio" name="role" class="admin_role role radio" value="2">教師(数学)
            </label>
            <label style="font-size:13px">
              <input type="radio" name="role" class="admin_role role radio" value="3">教師(英語)
            </label>
            <label style="font-size:13px" class="other_role">
              <input type="radio" name="role" class="other_role role radio" value="4">生徒
            </label>
          </div>
        </div>
        <!-- 生徒選択時に出てくる選択科目 -->
        <div class="select_teacher d-none">
          <label class="d-block m-0" style="font-size:13px">選択科目</label>
          @foreach($subjects as $subject)
          <div class="">
            <input type="checkbox" name="subject[]" value="{{ $subject->id }}">
            <label>{{ $subject->subject }}</label>
          </div>
          @endforeach
        </div>
        <!-- パスワードバリデーションメッセージ -->
        @if($errors->has('password'))
        @foreach($errors->get('password') as $message)
        <span class="error_message">{{ $message }}</span><br>
        @endforeach
        @endif
        <div class="mt-3">
          <label class="d-block m-0" style="font-size:13px">パスワード</label>
          <div class="border-bottom border-primary">
            <input type="password" class="border-0 w-100 password" name="password">
          </div>
        </div>
        <div class="mt-3">
          <label class="d-block m-0" style="font-size:13px">確認用パスワード</label>
          <div class="border-bottom border-primary">
            <input type="password" class="border-0 w-100 password_confirmation" name="password_confirmation">
          </div>
        </div>
        <div class="register_btn_content">
          <input type="submit" class="btn btn-primary register_btn" disabled value="新規登録" onclick="return confirm('登録してよろしいですか？')">
        </div>
        <div class="text-center">
          <!-- loginViewからloginに修正。 -->
          <a href="{{ route('login') }}">ログインはこちら</a>
        </div>
      </div>
    </div>
    {{ csrf_field() }}
  </form>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="{{ asset('js/register.js') }}" rel="stylesheet"></script>
</body>

</html>
