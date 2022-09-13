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
        Schema::table('reports', function (Blueprint $table) {
            $table->float('monday_bonus')->nullable();
            $table->float('tuesday_bonus')->nullable();
            $table->float('wednesday_bonus')->nullable();
            $table->float('thursday_bonus')->nullable();
            $table->float('friday_bonus')->nullable();
            $table->float('saturday_bonus')->nullable();
            $table->float('sunday_bonus')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('monday_bonus');
            $table->dropColumn('tuesday_bonus');
            $table->dropColumn('wednesday_bonus');
            $table->dropColumn('thursday_bonus');
            $table->dropColumn('friday_bonus');
            $table->dropColumn('saturday_bonus');
            $table->dropColumn('sunday_bonus');
            

        });
    }
};
