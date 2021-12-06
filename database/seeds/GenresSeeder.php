<?php

use Illuminate\Database\Seeder;

class GenresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genres')->insert([
            [
                'id' => 1,
                'name' => '完成図書',
    
            ],
            [
                'id' => 2,
                'name' => 'クレーム資料',
            ],
            
        ]);
    }
}
