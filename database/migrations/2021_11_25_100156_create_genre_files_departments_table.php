<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenreFilesDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genre_files_departments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('genre_file_id');
            $table->unsignedBigInteger('department_id');
            $table->timestamps();

            $table->foreign('genre_file_id')->references('id')->on('genre_files')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');

            $table->unique(['genre_file_id', 'department_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genre_files_departments');
    }
}
