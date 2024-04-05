<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans_payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id');
            $table->string('loan_id');
            $table->string('installments');
            $table->string('total_loan');
            $table->string('payment_per_installments');
            $table->string('status');
            $table->date('due_date');
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
        Schema::dropIfExists('loans_payments');
    }
}
