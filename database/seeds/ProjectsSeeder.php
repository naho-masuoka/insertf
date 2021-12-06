<?php

use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert([
            [
                'id' => 1,
                'prepareid' => '〇〇1',
                'projectid' => '■■1',
                'machineid' => '△△1',
                'keywords' => '〇〇1■■1△△1',
    
            ],
            [
                'id' => 2,
                'prepareid' => '〇〇2',
                'projectid' => '■■2',
                'machineid' => '△△2',
                'keywords' => '〇〇2■■2△△2',
            ],
            
        ]);
    }
}
