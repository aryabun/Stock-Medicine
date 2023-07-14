<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScreeningDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screening_datas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->float('height');
            $table->float('waist_circumference');
            $table->float('weight');
            $table->float('bmi');
            $table->float('bls_fasting');
            $table->float('bls_random');
            $table->float('blp_sytolic');
            $table->float('blp_diastolic');
            $table->float('pulse_heart');
            $table->float('HbA1c');
            $table->integer('keton');
            $table->integer('proteinuria');
            $table->float('cholesterol');
            $table->integer('tobacco');
            $table->integer('high_blp');
            $table->integer('diabete');
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
        Schema::dropIfExists('screening_datas');
    }
}
