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
                'name' => '〇〇資料',
    
            ],
            [
                'id' => 2,
                'department_id' => 2,
                'name' => '〇〇資料',
            ],
            [
                'id' => 3,
                'department_id' => 3,
                'name' => '〇〇資料',
            ],
            [
                'id' => 4,
                'department_id' => 4,
                'name' => '〇〇資料',
            ],
            [
                'id' => 5,
                'department_id' => 5,
                'name' => '〇〇資料',
            ],
            [
                'id' => 6,
                'department_id' => 6,
                'name' => '〇〇資料',
            ],
        ]);
    }
}
