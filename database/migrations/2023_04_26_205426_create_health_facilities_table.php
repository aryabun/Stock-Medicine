<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('health_facilities')) {
        Schema::create('health_facilities', function (Blueprint $table) {
            $table->id();
            $table->string('postal_code');
            $table->string('name_kh');
            $table->string('name_en');
            $table->string('prefix')->nullable();
            $table->string('prefix_code')->nullable();
            $table->string('level');
            $table->string('od');
            $table->string('address')->nullable();
            $table->integer('p_code');
            $table->integer('d_code');
            $table->integer('c_code');
            $table->integer('v_code');
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('health_facilities');
    }
}
