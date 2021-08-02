<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePremiumSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premium_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->date('expiry');
            $table->decimal('amount',8,2);
            $table->decimal('vat',8,2);
            $table->mediumText('trans_data');
            $table->string('track_id');
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
        Schema::dropIfExists('premium_subscriptions');
    }
}
