<?php

namespace App\Http\Controllers\Authenticated\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Gate;
use App\Models\Users\User;
use App\Models\Users\Subjects;
use App\Searchs\DisplayUsers;
use App\Searchs\SearchResultFactories;

class UsersController extends Controller
{

    // ユーザー検索画面表示
    public function showUsers(Request $request){
        // それぞれの値を取得して格納する
        $keyword = $request->keyword;
        $category = $request->category;
        $updown = $request->updown;
        $gender = $request->sex;
        $role = $request->role;
        $subjects = $request->subject; // ここで検索時の科目を受け取る
        $userFactory = new SearchResultFactories(); // SearchResultFactoriesモデル使用(値の取り出し)
        $users = $userFactory->initializeUsers($keyword, $category, $updown, $gender, $role, $subjects); // $userFactory(SearchResultFactoriesモデル)内のinitializeUsersメソッドを使用して格納した値をまとめる
        $subjects = Subjects::all(); //Subjectsモデルの値を取得
        return view('authenticated.users.search', compact('users', 'subjects'));
    }

    // ユーザー情報詳細画面表示
    public function userProfile($id){
        $user = User::with('subjects')->findOrFail($id); // Userモデルと関連するsubjectsテーブルを取得->$idが見つからなければエラー文を出す
        $subject_lists = Subjects::all(); //Subjectsモデルの値を取得
        return view('authenticated.users.profile', compact('user', 'subject_lists'));
    }

    // 選択科目編集機能
    public function userEdit(Request $request){
        $user = User::findOrFail($request->user_id); // ユーザーIDを探して見つからなかったらエラー文を出す
        $user->subjects()->sync($request->subjects); //$user->リレーションメソッド->中間テーブル(subject_users)の値を追加するsyncメソッド
        return redirect()->route('user.profile', ['id' => $request->user_id]);
    }
}
