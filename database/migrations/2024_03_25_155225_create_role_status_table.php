<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_status', function (Blueprint $table) {
            $table->id();
            $table->string('role_status_name');
            $table->timestamps();
        });

        DB::table('role_status')->insert([
            ['role_status_name' => 'Super Admin'],
            ['role_status_name' => 'Admin'],
            ['role_status_name' => 'Employee'],
        ]);
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_status');
    }
}
