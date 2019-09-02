<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AssetMedia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_media', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('asset_id');
            $table->unsignedBigInteger('media_id');

            $table->foreign('asset_id')
                ->references('id')
                ->on('assets');

            $table->foreign('media_id')
                ->references('id')
                ->on('media');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
