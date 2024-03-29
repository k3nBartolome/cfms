<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToInventory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory', function (Blueprint $table) {
            $table->integer('transferred_quantity')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->unsignedBigInteger('transferred_by')->nullable();
            $table->unsignedBigInteger('transferred_from')->nullable();
            $table->unsignedBigInteger('transferred_to')->nullable();
            $table->unsignedBigInteger('cancelled_by')->nullable();
            $table->datetime('transferred_date')->nullable();
            $table->datetime('cancelled_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory', function (Blueprint $table) {
            $table->integer('transferred_quantity');
            $table->string('cancellation_reason')->nullable();
            $table->foreign('transferred_by')->references('id')->on('users');
            $table->foreign('cancelled_by')->references('id')->on('users');
            $table->foreign('transferred_from')->references('id')->on('sites');
            $table->foreign('transferred_to')->references('id')->on('sites');
            $table->datetime('transferred_date')->nullable();
            $table->datetime('cancelled_date')->nullable();
        });
    }
}
