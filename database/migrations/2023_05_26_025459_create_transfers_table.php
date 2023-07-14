<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_id')->unique();
            $table->string('request_id')->unique();
            $table->string('contact_id');
            $table->string('from_warehouse');
            $table->string('to_warehouse');
            $table->string('approved_by')->nullable();
            $table->date('approved_date')->nullable();
            $table->date('schedule_date')->nullable();
            $table->date('eta')->nullable();
            $table->string('total_price')->nullable();
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
        Schema::dropIfExists('transfers');
    }
}
