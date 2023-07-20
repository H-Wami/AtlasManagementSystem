<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Users\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;

use App\Models\Users\Subjects;

use App\Http\Requests\RegisterFormRequest; // フォームリクエスト使用

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function registerView()
    {
        $subjects = Subjects::all();
        return view('auth.register.register', compact('subjects'));
    }

    // 新規ユーザー登録機能
    public function registerPost(RegisterFormRequest $request) //フォームリクエスト使用
    {
        DB::beginTransaction(); //トランザクション(一連の処理のまとめ)開始
        try{ //例外が起こる可能性のある処理
            $old_year = $request->old_year;
            $old_month = $request->old_month;
            $old_day = $request->old_day;
            $data = $old_year . '-' . $old_month . '-' . $old_day;
            $birth_day = date('Y-m-d', strtotime($data)); // (年4桁・月2桁・日付2桁,の入力された$dataを出力)
            $subjects = $request->subject;

            if($data !== $birth_day){
                echo '入力された生年月日は存在しません。';
                dd($data,$birth_day);
            }

            $user_get = User::create([ //新規ユーザー登録実行
                'over_name' => $request->over_name,
                'under_name' => $request->under_name,
                'over_name_kana' => $request->over_name_kana,
                'under_name_kana' => $request->under_name_kana,
                'mail_address' => $request->mail_address,
                'sex' => $request->sex,
                'birth_day' => $birth_day,
                'role' => $request->role,
                'password' => bcrypt($request->password) //ハッシュ値取得
            ]);
            $user = User::findOrFail($user_get->id);// 新規登録したIDを探して見つからなかったらエラー文を出す
            $user->subjects()->attach($subjects);
            DB::commit(); // トランザクションで実行したSQLをすべて確定する
            return view('auth.login.login'); //ログインページ表示(Controllerで特定のViewを表示)
        }catch(\Exception $e){ //例外が起こった時の処理
            DB::rollback(); // トランザクションで実行したSQLをすべて破棄する
            return redirect()->route('loginView'); //ログインページリダイレクト(Controllerで特定のページへリダイレクト)
        }
    }
}
