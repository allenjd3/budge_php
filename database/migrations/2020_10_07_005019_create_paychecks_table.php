<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaychecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paychecks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('payday');
            $table->date('pay_date');
            $table->bigInteger('user_id');
            $table->bigInteger('month_id');
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
        Schema::dropIfExists('paychecks');
    }
}
