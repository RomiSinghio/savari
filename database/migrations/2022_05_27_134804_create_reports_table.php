<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET SESSION sql_require_primary_key=0');
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('week_id')->nullable();
            $table->foreignId('driver_id')->nullable();
            $table->float('monday_hours')->nullable();
            $table->float('tuesday_hours')->nullable();
            $table->float('wednesday_hours')->nullable();
            $table->float('thursday_hours')->nullable();
            $table->float('friday_hours')->nullable();
            $table->float('saturday_hours')->nullable();
            $table->float('sunday_hours')->nullable();
            $table->float('monday_fixed')->nullable();
            $table->float('tuesday_fixed')->nullable();
            $table->float('wednesday_fixed')->nullable();
            $table->float('thursday_fixed')->nullable();
            $table->float('friday_fixed')->nullable();
            $table->float('saturday_fixed')->nullable();
            $table->float('sunday_fixed')->nullable();
            $table->float('food_allowance')->nullable();
            $table->float('fuel_allowance')->nullable();
            $table->float('total_hours')->nullable();
            $table->float('net_pay')->nullable();
            $table->string('payslip')->nullable();
            $table->float('deductions')->nullable();
            $table->float('expenses')->nullable();
            $table->mediumText('notes')->nullable();
            $table->float('gross_pay')->nullable();
            $table->float('actual_pay')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('reports');
    }
};
