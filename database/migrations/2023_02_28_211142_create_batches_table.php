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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('quantity');
            $table->unsignedFloat('width');
            $table->unsignedFloat('height');
            $table->integer('cart_id');
            $table->string('variant');
            $table->boolean('wholesale')->default(false);
            $table->integer('price_snapshot_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('batches');
    }
};
