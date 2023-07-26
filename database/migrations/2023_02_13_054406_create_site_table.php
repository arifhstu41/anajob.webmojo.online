<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site', function (Blueprint $table) {
            $table->id();
            $table->string('account_id')->nullable();
            $table->string('site_name')->nullable();
            $table->string('property_id')->nullable();
            $table->string('property_name')->nullable();
            $table->string('view_id')->nullable();
            $table->string('view_name')->nullable();
            $table->string('accessToken')->nullable();
            $table->string('refreshToken')->nullable();
            $table->string('timeframe')->default('30daysAgo');
            $table->string('graph')->nullable()->default('ga:users');
            $table->string('graph_type')->nullable()->default('line');
            $table->string('graph_color')->nullable()->default('#172b4d');
            $table->string('top_left')->nullable()->default('ga:users');
            $table->string('top_right')->nullable()->default('ga:users');
            $table->string('bottom_left')->nullable()->default('ga:users');
            $table->string('bottom_right')->nullable()->default('ga:bounceRate');
            $table->string('share_setting',5000)->nullable();
            $table->string('created_by')->default(0);
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
        Schema::dropIfExists('site');
    }
};
