<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account');
            $table->date('date');
            $table->string('description');
            $table->string('category')->nullable();
            $table->float('amount');
            $table->string('imported_description1');
            $table->string('imported_description2');
            $table->timestamps();

            $table->foreign('category')->references('category')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transactions');
    }
}
