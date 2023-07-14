<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_code')->unique();
            $table->string('product_name')->unique();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('unit')->default("Bottle")->nullable(); //bottle or tablet
            $table->string('strength')->nullable();
            $table->string('med_type')->nullable();
            $table->string('disease_type')->nullable();
            $table->boolean('status')->nullable(); // true if available stock
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
        Schema::dropIfExists('products');
    }
}
