<?php

use Illuminate\Database\Seeder;

class Genre_filesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genre_files_departments')->insert([
            [
                'id' => 1,
                'genre_file_id' => 1,
                'department_id' => 4,

    
            ],
            [
                'id' => 2,
                'genre_file_id' => 3,
                'department_id' => 4,
            ],
            [
                'id' => 3,
                'genre_file_id' => 5,
                'department_id' => 3,
            ],
        ]);
    }
}
