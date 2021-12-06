<?php

use Illuminate\Database\Seeder;

class FilegenresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genre_files')->insert([
            [
                'id' => 1,
                'name' => '〇〇資料',
                'sort_no' =>1,
                'department_id' => 3,
    
            ],
            [
                'id' => 2,
                'name' => '□□資料',
                'sort_no' =>2,
                'department_id' => 3,
            ],
            [
                'id' => 3,
                'name' => '▼▼資料',
                'sort_no' =>3,
                'department_id' => 3,
            ],
            [
                'id' => 4,
                'name' => '◇◇資料',
                'sort_no' =>1,
                'department_id' => 4,
            ],
            [
                'id' => 5,
                'name' => '■■資料',
                'sort_no' =>2,
                'department_id' => 4,
            ],
            [
                'id' => 6,
                'name' => '△△資料',
                'sort_no' =>4,
                'department_id' => 3,
            ],
        ]);
    }
}
