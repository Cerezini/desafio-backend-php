<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtherTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cnpj');
            $table->string('fantasy_name');
            $table->string('social_name');
            $table->integer('user_id')->unsigned()->unique();
            $table->string('username')->unique();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::create('consumers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->unique();
            $table->string('username')->unique();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payee_id')->unsigned();
            $table->integer('payer_id')->unsigned();
            $table->dateTime('transaction_date');
            $table->decimal('value', 8, 2);

            $table->foreign('payee_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('payer_id')
                ->references('id')->on('users')
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
        Schema::dropIfExists('sellers');
        Schema::dropIfExists('consumers');
        Schema::dropIfExists('transactions');
    }
}
