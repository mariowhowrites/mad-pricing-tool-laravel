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
        Schema::create('price_measurements', function (Blueprint $table) {
            $table->id();
            $table->integer('price_snapshot_id');
            $table->unsignedFloat('width');
            $table->unsignedFloat('height');
            $table->unsignedInteger('quantity');
            $table->unsignedFloat('price');
            $table->integer('square_inches')->virtualAs('width * height * quantity');
            $table->float('price_per_square_inch', 8, 3)->virtualAs('price / square_inches');
            $table->string('variant')->nullable();
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
        Schema::dropIfExists('price_measurements');
    }
};
