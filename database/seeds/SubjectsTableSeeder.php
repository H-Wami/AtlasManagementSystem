<?php

use Illuminate\Database\Seeder;
use App\Models\Users\Subjects;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 初期データ入力 table('テーブル名')
        DB::table('subjects')->insert([
            // ['カラム名' => '値']
            ['subject' => '国語'],
            ['subject' => '数学'],
            ['subject' => '英語']
        ]);
        // 国語、数学、英語を追加
    }
}
