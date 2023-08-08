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
        DB::beginTransaction();
        try{
            $getPart = $request->getPart;
            $getDate = $request->getData;
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            foreach($reserveDays as $key => $value){
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                $reserve_settings->decrement('limit_users');
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

    // スクール予約削除(キャンセル)機能
    public function delete(Request $request){
        $reserve_setting_id = $request->id; // 予約枠のid格納
        $user_id = Auth::id(); // ログインユーザーID格納
        $reserve = ReserveSettings::find($reserve_setting_id); // reserve_settingsテーブルから$reserve_setting_idに該当する値を格納
        $reserve->users()->detach($user_id); // $reserve->リレーションメソッド->$user_idの中間テーブルの値を削除
        return redirect()->route('calendar.general.show', ['user_id' => $user_id]);
    }
}
