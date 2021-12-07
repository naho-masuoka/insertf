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
        $this->call(DepartmentsSeeder::class);
        $this->call(DocumentsSeeder::class);
        $this->call(FilegenresSeeder::class);
        $this->call(GenresSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(ProjectsSeeder::class);
        $this->call(Genre_filesSeeder::class);
        
    }
}
