<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currency_report_type', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique();
            $table->integer('interval');
            $table->integer('range');
        });
        DB::table('currency_report_type')->insert(
            [
                'uid' => 'ONE_YEAR_ONE_MONTH',
                'interval' => 30,
                'range' => 365
            ]
        );
        DB::table('currency_report_type')->insert(

            [
                'uid' => 'SIX_MONTHS_ONE_WEEK',
                'interval' => 7,
                'range' => 365
            ]
        );
        DB::table('currency_report_type')->insert(

            [
                'uid' => 'ONE_MONTH_ONE_DAY',
                'interval' => 1,
                'range' => 30
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_report_type');
    }
};
