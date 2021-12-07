<?php

use Illuminate\Database\Seeder;

class DocumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('documents')->insert([
            [
                'id' => 1,
                'department_id' => 1,
                'name' => '実験の資料',
    
            ],
            [
                'id' => 2,
                'department_id' => 2,
                'name' => '開発の資料',
            ],
            [
                'id' => 3,
                'department_id' => 3,
                'name' => '設計の資料',
            ],
            [
                'id' => 4,
                'department_id' => 4,
                'name' => '営業の資料',
            ],
            [
                'id' => 5,
                'department_id' => 4,
                'name' => '営業の資料2',
            ],
            [
                'id' => 6,
                'department_id' => 5,
                'name' => '技術の資料',
            ],
            [
                'id' => 7,
                'department_id' => 6,
                'name' => '管理の資料',
            ],
        ]);
    }
}
