<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('taskId');
            $table->foreign('taskId')->references('id')->on('tasks')->onDelete('cascade');
            $table->string('attribute');
            $table->string('isDone')->default('0');
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
        Schema::dropIfExists('task_attributes');
    }
}
