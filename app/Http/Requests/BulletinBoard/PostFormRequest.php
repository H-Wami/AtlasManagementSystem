<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'post_category_id' => 'required|integer|exists:post_sub_categories,sub_category_id',
            'post_title' => 'required|string|max:100', //'初期値 min:4|max:50'
            'post_body' => 'required|string|max:5000', //'初期値　min:10|max:500'
        ];
    }

    public function messages(){
        return [
            // 初期値
            // 'post_title.min' => 'タイトルは4文字以上入力してください。',
            // 'post_title.max' => 'タイトルは50文字以内で入力してください。',
            // 'post_body.min' => '内容は10文字以上入力してください。',
            // 'post_body.max' => '最大文字数は500文字です。',



            'post_title.required' => 'タイトルは入力必須です。',
            'post_title.max' => 'タイトルは100文字以下で入力して下さい。',

            'post_body.required' => '内容は入力必須です。',
            'post_body.max' => '内容は5000文字以下で入力して下さい。',
        ];
    }
}
