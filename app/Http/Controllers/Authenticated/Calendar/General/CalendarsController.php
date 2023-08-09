<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    // スクール予約画面表示
    public function show(){
        $calendar = new CalendarView(time()); // CalenderViewモデル使用(値の取り出し)
        // time()で現在時刻を渡して今月のカレンダーを用意
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    // スクール予約登録機能
    public function reserve(Request $request){
        DB::beginTransaction(); //トランザクション(一連の処理のまとめ)開始
        try{ //例外が起こる可能性のある処理
            $getPart = $request->getPart; //予約選択の配列格納(部) ex.19 => 3 個数変化する
            $getDate = $request->getData; // 日付のフォーマット配列格納 ex.19 => "2023-08-20" 個数変化なし
            $reserveDays = array_filter(array_combine($getDate, $getPart)); // 2つの配列を結合する
            foreach($reserveDays as $key => $value){
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first(); // ReserveSettingsモデルからsetting_reserveカラムと$keyが同じ->setting_partカラムと$valueが同じ->取得
                $reserve_settings->decrement('limit_users'); // $reserve_settings->limit_users(人数)カラムを1減らす
                $reserve_settings->users()->attach(Auth::id()); // $reserve_settings->リレーションメソッド->$user_idの中間テーブルの値を追加
            }
            DB::commit(); // トランザクションで実行したSQLをすべて確定する
        }catch(\Exception $e){ //例外が起こった時の処理
            DB::rollback(); // トランザクションで実行したSQLをすべて破棄する
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]); //スクール予約ページリダイレクト(Controllerで特定のページへリダイレクト)
    }

    // スクール予約削除(キャンセル)機能
    public function delete(Request $request)
    {
        DB::beginTransaction(); //トランザクション(一連の処理のまとめ)開始
        try { //例外が起こる可能性のある処理
            $reserve_setting_id = $request->id; // 予約枠のid格納
            $user_id = Auth::id(); // ログインユーザーID格納
            $reserve = ReserveSettings::find($reserve_setting_id); // reserve_settingsテーブルから$reserve_setting_idに該当する値を格納
            $reserve->increment('limit_users'); // $reserve->limit_users(人数)カラムを1増やす
            $reserve->users()->detach($user_id); // $reserve->リレーションメソッド->$user_idの中間テーブルの値を削除
            DB::commit(); // トランザクションで実行したSQLをすべて確定する
        } catch (\Exception $e) { //例外が起こった時の処理
            DB::rollback(); // トランザクションで実行したSQLをすべて破棄する
        }
        return redirect()->route('calendar.general.show', ['user_id' => $user_id]); //スクール予約ページリダイレクト(Controllerで特定のページへリダイレクト)
    }
}
