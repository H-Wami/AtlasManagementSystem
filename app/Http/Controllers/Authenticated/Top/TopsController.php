<?php

namespace App\Http\Controllers\Authenticated\Top;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class TopsController extends Controller
{
    // トップ画面表示
    public function show(){
        return view('authenticated.top.top');
    }

    // ログアウト機能
    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
