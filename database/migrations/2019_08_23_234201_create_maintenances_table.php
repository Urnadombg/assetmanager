<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('perform_on');
            $table->uuid('protocolUUID');
            $table->boolean('isWarrantyEvent')->nullable();
//            $table->unsignedBigInteger('asset_id')->nullable();
//            $table->unsignedBigInteger('component_id')->nullable();

            $table->text('explanation');

//            $table->foreign('asset_id')->references('id')->on('assets');
//            $table->foreign('component_id')->references('id')->on('components');

            $table->softDeletes();
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
        Schema::dropIfExists('maintenances');
    }
}
