<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('request_id')->unique();
            $table->string('user_id');
            $table->string('from_warehouse');
            $table->string('to_warehouse');
            $table->string('approved_by')->nullable();
            $table->date('approved_date')->nullable();
            $table->string('rejected_by')->nullable();
            $table->date('rejected_date')->nullable();
            $table->string('transfer_ref')->nullable();
            $table->string('received_by')->nullable();
            $table->date('received_date')->nullable();
            $table->string('received_ref')->nullable();
            $table->date('schedule_date')->nullable();
            $table->date('eta')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('request_transfers');
    }
}
