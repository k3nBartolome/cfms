<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('requirements', function (Blueprint $table) {
            $table->string('bgc_results')->nullable();
        });
    }

    public function down()
    {
        Schema::table('requirements', function (Blueprint $table) {
            $table->dropColumn('bgc_results');
        });
    }
};
