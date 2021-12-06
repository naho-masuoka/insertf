<?php

use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            [
                'id' => 1,
                'departmentid' => '1',
                'name1' => '〇〇事業部',
                'name2' => '実験',
    
            ],
            [
                'id' => 2,
                'departmentid' => '2',
                'name1' => '〇〇事業部',
                'name2' => '開発',
            ],
            [
                'id' => 3,
                'departmentid' => '3',
                'name1' => '〇〇事業部',
                'name2' => '設計',
            ],
            [
                'id' => 4,
                'departmentid' => '4',
                'name1' => '〇〇事業部',
                'name2' => '営業1課',
            ],
            [
                'id' => 5,
                'departmentid' => '5',
                'name1' => '〇〇事業部',
                'name2' => '技術',
            ],
            [
                'id' => 6,
                'departmentid' => '6',
                'name1' => '〇〇事業部',
                'name2' => '管理',
            ],
        ]);
    }
}
