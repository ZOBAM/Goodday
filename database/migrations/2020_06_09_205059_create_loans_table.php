<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->float('repay_amount');
            $table->unsignedBigInteger('receiver_id');
            $table->foreign('receiver_id')->references('id')->on('customers');
            $table->string('loan_type');
            $table->string('repay_interval');
            $table->string('repay_unit');//amount to be paid per repay interval
            $table->timestamp('application_date');
            $table->unsignedBigInteger('approved_by');
            $table->foreign('approved_by')->references('id')->on('users');
            $table->timestamp('approval_date')->nullable();
            $table->smallInteger('same_count');
            $table->boolean('disbursed');
            $table->timestamp('disbursed_date')->nullable();
            $table->float('outstanding_amount');//can add bad_loan? later to mark bad loans
            $table->timestamp('last_repay_date')->nullable();
            $table->boolean('loan_cleared');
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
        Schema::dropIfExists('loans');
    }
}
