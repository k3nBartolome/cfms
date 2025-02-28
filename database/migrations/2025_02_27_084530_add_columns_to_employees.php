<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('contract')->nullable();
            $table->string('with_findings')->nullable();
            $table->date('date_endorsed_to_compliance')->nullable();
            $table->date('return_to_hs_with_findings')->nullable();
            $table->date('last_received_from_hs_with_findings')->nullable();
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'contract',
                'with_findings',
                'date_endorsed_to_compliance',
                'return_to_hs_with_findings',
                'last_received_from_hs_with_findings'
            ]);
        });
    }
};
