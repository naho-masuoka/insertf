<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('claim_id')->nullable();
            $table->string('name');
            $table->integer('branch')->nullable();
            $table->string('extension');
            $table->unsignedBigInteger('genre_id')->nullable();
            $table->timestamps();
            
            $table->foreign('claim_id')->references('id')->on('claims');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('project_id')->references('id')->on('projects');            
            $table->foreign('genre_id')->references('id')->on('genres');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
