<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // 初期ユーザー
        $this->call(UsersTableSeeder::class);
        // 初期値(教科)
        $this->call(SubjectsTableSeeder::class);
    }
}
