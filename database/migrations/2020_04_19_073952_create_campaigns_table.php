<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_type_id');
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->string('slug');
            $table->longText('description');
            $table->string('province');
            $table->string('district');
            $table->string('sub_district');
            $table->string('village');
            $table->text('address');
            $table->double('target_fund')->nullable();
            $table->date('deadline')->nullable();
            $table->string('status');
            $table->smallInteger('featured_media');
            $table->string('featured_image')->nullable();
            $table->string('featured_video')->nullable();
            $table->smallInteger('is_deleted')->default(0);
            $table->timestamps();

            $table->foreign('campaign_type_id')->references('id')->on('campaign_types');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
}
