<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavingsCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savings_collections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('saving_id');
            $table->foreign('saving_id')->references('id')->on('savings');
            $table->float('amount_saved');
            $table->unsignedBigInteger('collected_by');
            $table->foreign('collected_by')->references('id')->on('users');
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
        Schema::dropIfExists('savings_collections');
    }
}
