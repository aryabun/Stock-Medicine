<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_boxes', function (Blueprint $table) {
            $table->id();
            $table->string('box_code')->unique();
            $table->string('product_code');
            $table->string('lot_code');
            $table->integer('bottle_qty')->default(0);
            $table->integer('qty_per_bottle')->nullable();
            $table->string('unit')->nullable();
            $table->boolean('status')->nullable();
            $table->date('exp_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_boxes');
    }
}
