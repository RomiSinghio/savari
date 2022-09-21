<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('driver', function (Blueprint $table) {
            $table->integer('holidays_used');
            $table->integer('contract_hours');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('driver', function (Blueprint $table) {
            $table->dropColumn('holidays_used');
            $table->dropColumn('contract_hours');
        });
    }
};
