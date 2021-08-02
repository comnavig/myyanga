<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSoldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_solds', function (Blueprint $table) {
            $table->id();
            $table->string('quantity');
            $table->bigInteger('product_id');
            $table->longText('delivery');
            $table->bigInteger('order_id');
            $table->decimal('amount', 17, 2);
            $table->string('delivery_status');
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
        Schema::dropIfExists('product_solds');
    }
}
