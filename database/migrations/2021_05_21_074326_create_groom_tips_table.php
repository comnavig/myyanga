<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroomTipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groom_tips', function (Blueprint $table) {
            $table->id();
			$table->string('name');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->bigInteger('category_id');
            $table->bigInteger('user_id');
            $table->string('status');
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
        Schema::dropIfExists('groom_tips');
    }
}
