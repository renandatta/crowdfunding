<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('donation_id');
            $table->unsignedBigInteger('payment_type_id');
            $table->double('unique_code');
            $table->double('total');
            $table->timestamps();

            $table->foreign('donation_id')->references('id')->on('donations');
            $table->foreign('payment_type_id')->references('id')->on('payment_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donation_payments');
    }
}
