<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_status', function (Blueprint $table) {
            $table->id();
            $table->string('account_status_name');
            $table->timestamps();
        });

        DB::table('account_status')->insert([
            ['account_status_name' => 'Active'],
            ['account_status_name' => 'Inactive'],
            ['account_status_name' => 'Disable'],
        ]);
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_status');
    }
}
