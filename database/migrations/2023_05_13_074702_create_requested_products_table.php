<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requested_products', function (Blueprint $table) {
            $table->id();
            $table->string('request_id');
            $table->string('product_code');
            $table->integer('qty');
            $table->string('unit');
            $table->timestamps();

            $table->foreign('request_id')->references('request_id')->on('request_transfers')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('requested_products');
    }
}
