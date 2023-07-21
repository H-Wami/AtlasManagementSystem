<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // falseからtrueに変更。
    }

    /**
     * rules()の前に実行される
     * $this->merge(['key' => $value])を実行すると、
     * フォームで送信された(key, value)の他に任意の(key, value)の組み合わせをrules()に渡せる
     * old_year old_month old_dayをひとまとめにする
     */
     public function getValidatorInstance()
     {
        // 生年月日作成
        $old_year = $this->input('old_year');
        $old_month = $this->input('old_month');
        $old_day = $this->input('old_day');
        $data = $old_year . '-' . $old_month . '-' . $old_day;

        // rule()に渡す値を追加でセット merge=データを結合
        $this->merge([
            'birth_day' => $data,
        ]);

        // 親クラスのメソッドを呼び出す
        return parent::getValidatorInstance();
     }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules() // バリデーション条件　
    {
        return [
            //'項目名' => '検証ルール|検証ルール',
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|regex:/\A[ァ-ヴー]+\z/u|max:30',
            'under_name_kana' => 'required|string|regex:/\A[ァ-ヴー]+\z/u|max:30',
            'mail_address' => 'required|string|email|unique:users,mail_address|max:100',
            'sex' => 'required|integer|in:1,2,3', // valueの1~3の値だけにしたい
            'birth_day' => 'required|date|after_or_equal:2000-01-01|before_or_equal:today',
            'role' => 'required|integer|in:1,2,3,4', // valueの1~4の値だけにしたい
            'password' => 'required|min:8|max:30|confirmed',
            'password_confirmation' => 'required|min:8|max:30'
        ];
    }

    public function messages()
    {
        return [
            //'項目名.検証ルール' => 'メッセージ',
            //入力必須は新規登録ボタンのdisabled属性があるため、省略

            'over_name.max' => '姓は10文字以下で入力して下さい。',
            'under_name.max' => '名は10文字以下で入力して下さい。',

            'over_name_kana.max' => 'セイは30文字以下で入力して下さい。',
            'over_name_kana.regex' => 'セイはカタカナで入力して下さい。',
            'under_name_kana.max' => 'メイは30文字以下で入力して下さい。',
            'under_name_kana.regex' => 'メイはカタカナで入力して下さい。',

            'mail_address.max' => 'メールアドレスは100文字以下で入力して下さい。',
            'mail_address.unique' => '登録済みのメールアドレスは使用不可です。',
            'mail_address.email' => 'メールアドレスの形式で入力して下さい。',

            'birth_day.date' => '入力された生年月日は存在しません。',
            'birth_day.before_or_equal' => '今日より前の日付を入れて下さい。',

            'password.min' => 'パスワードは8文字以上で入力して下さい。',
            'password.max' => 'パスワードは30文字以下で入力して下さい。',
            'password.confirmed' => 'パスワードが一致していません。'
        ];
    }
}
