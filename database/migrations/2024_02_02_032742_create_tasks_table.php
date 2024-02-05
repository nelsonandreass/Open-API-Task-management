<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //status
        //1 = on progress
        //2 = pending
        //3 = done
        //priority
        //1 = low
        //2 = medium
        //3 = high
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('headline');
            $table->string('description');
            $table->string('status')->default("1");
            $table->string('priority')->default("1");
            $table->string('categoryId')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
