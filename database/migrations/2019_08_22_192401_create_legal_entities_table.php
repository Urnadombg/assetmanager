<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegalEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legalentities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('companyName');
            $table->string('address');
            $table->string('officialPersonInCharge')->nullable();
            $table->string('bulstat')->nullable();
            $table->boolean('isEntityRegisteredInVATRegister')->nullable();
            $table->unsignedBigInteger('customer_id');

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');

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
        Schema::dropIfExists('legal_entities');
    }
}
