<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('requirements', function (Blueprint $table) {
            $table->string('peme_vendor')->nullable();
            $table->string('bgc_vendor')->nullable();
            $table->date('cibi_search_date')->nullable();
        });
    }

    public function down()
    {
        Schema::table('requirements', function (Blueprint $table) {
            $table->dropColumn(['peme_vendor', 'bgc_vendor', 'cibi_search_date']);
        });
    }
};
