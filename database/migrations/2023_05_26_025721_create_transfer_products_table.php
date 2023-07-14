<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_products', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_id');
            $table->integer('qty');
            $table->string('box_code');
            $table->string('product_code');
            $table->string('price')->nullable();
            $table->string('unit')->nullable();
            $table->timestamps();

            $table->foreign('transfer_id')->references('transfer_id')->on('transfers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('box_code')->references('box_code')->on('product_boxes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('product_code')->references('product_code')->on('products')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfer_products');
    }
}
