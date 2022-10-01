<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdercollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordercollections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->tinyInteger('makeed')->default(1);
            $table->tinyInteger('started')->default(0);
            $table->tinyInteger('in_way')->default(0);
            $table->tinyInteger('finished')->default(0);
            $table->tinyInteger('canceled')->default(0);
            $table->tinyInteger('completed')->default(0);
            $table->string('address');
            $table->string('payment_method');
            $table->integer('payment_id')->nullable();
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
        Schema::dropIfExists('ordercollections');
    }
}
