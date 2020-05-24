<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
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
            $table->unsignedBigInteger('origin_account_id');
            $table->unsignedBigInteger('destination_account_id');
            $table->unsignedBigInteger('customer_id');
            $table->decimal('amount');
            $table->timestamps();

            $table->foreign('origin_account_id')->references('id')->on('accounts');
            $table->foreign('destination_account_id')->references('id')->on('accounts');
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
