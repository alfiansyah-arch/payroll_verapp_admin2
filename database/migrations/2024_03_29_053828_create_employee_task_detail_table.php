<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTaskDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_task_details', function (Blueprint $table) {
            $table->id();
            $table->string('task_id');
            $table->string('user_id');
            $table->string('task_title');
            $table->text('task_description');
            $table->string('no_task');
            $table->string('date_start');
            $table->string('date_end');
            $table->string('status');
            $table->string('attachment');
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
        Schema::dropIfExists('employee_task_details');
    }
}
