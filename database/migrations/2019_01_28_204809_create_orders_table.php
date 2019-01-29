<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->string('email', 50);
            $table->bigInteger('phone', false, true);
            $table->bigInteger('phone2', false, true);
            $table->bigInteger('inn', false, true);
            $table->string('client_type', 10);
            $table->string('pay_type', 10);
            $table->string('delivery_type', 10);
            $table->string('address')->nullable();
            $table->dateTime('delivery_date')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
