<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('surname');
            $table->string('other_name');
            $table->string('gender');
            $table->string('phone_number')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('account_number')->unique()->nullable();
            $table->string('next_of_kin');
            $table->string('nok_relationship');
            $table->string('state');
            $table->string('lga');
            $table->string('community');
            $table->string('full_address');
            $table->unsignedBigInteger('group_id')->nullable();
            //$table->foreign('group_id')->references('id')->on('groups');
            $table->timestamp('membership_date')->nullable();
            $table->float('poverty_index')->nullable();
            $table->boolean('loanable')->nullable();
            $table->boolean('on_loan')->nullable();
            $table->integer('loan_count')->nullable();
            $table->boolean('dormant')->nullable();
            $table->string('passport_link')->nullable();
            $table->string('signature_link')->nullable();
            $table->unsignedBigInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('users');
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
        Schema::dropIfExists('customers');
    }
}
