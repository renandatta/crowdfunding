<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignUpdateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_update_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_update_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->longText('content');
            $table->smallInteger('is_deleted')->default(0);
            $table->timestamps();

            $table->foreign('campaign_update_id')->references('id')->on('campaign_updates');
            $table->foreign('parent_id')->references('id')->on('campaign_update_comments');
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
        Schema::dropIfExists('campaign_update_comments');
    }
}
