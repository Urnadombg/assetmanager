<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ComponentMaintenance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('component_maintenance', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('component_id');
            $table->unsignedBigInteger('maintenance_id');

            $table->foreign('component_id')
                ->references('id')
                ->on('components')
                ->onDelete('cascade');

            $table->foreign('maintenance_id')
                ->references('id')
                ->on('maintenances')
                ->onDelete('cascade');

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
