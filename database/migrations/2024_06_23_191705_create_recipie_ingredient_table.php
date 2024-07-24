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
        Schema::create('recipie_ingredient', function (Blueprint $table) {
            $table->id();
            $table->integer('recipie_id');
            $table->integer('ingredient_id');
            $table->text('ingredient_details');
            $table->string('quantity');
            $table->string('quantity_type');
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
        Schema::dropIfExists('recipie_ingredient');
    }
};
