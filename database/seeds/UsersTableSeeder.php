<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //初期ユーザー作成 table('テーブル名')
        DB::table('users')->insert([
            // 'カラム名' => '値'
            'over_name' => '早川',
            'under_name' => '和美',
            'over_name_kana' => 'ハヤカワ',
            'under_name_kana' => 'カズミ',
            'mail_address' => 'firstuser@icloud.com',
            'sex' => '2',
            'birth_day' => '19940927',
            'role' => '1',
            'password' => bcrypt('wami0927')
        ]);
    }
}
