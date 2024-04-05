<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('month');
            $table->date('date');
            $table->time('entry_time')->nullable();
            $table->time('exit_time')->nullable();
            $table->string('entry_photo')->nullable();
            $table->string('exit_photo')->nullable();
            $table->text('entry_location')->nullable();
            $table->text('exit_location')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('attendances');
    }
}
