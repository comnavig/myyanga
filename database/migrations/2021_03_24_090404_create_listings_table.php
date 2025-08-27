<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->longText('logo');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('cac');
            $table->string('cac_no');
            //~ $table->longText('operating_time')->nullable();
            $table->longText('address');
            $table->longText('description');
            $table->bigInteger('parent_id');
            $table->bigInteger('location_id');
            //~ $table->bigInteger('plan_id');
            $table->bigInteger('user_id');
            $table->string('status');
            $table->string('featured');
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
        Schema::dropIfExists('listings');
    }
}
