<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Database\Seeders\CurrencyConversionSeeder;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currency_conversion', function (Blueprint $table) {
            $table->id();
            $table->string('abbreviation_pair');
            $table->string('convert_from');
            $table->string('convert_to');
            $table->float('value');
            $table->timestamps();
        });
        (new CurrencyConversionSeeder)->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_conversion');
    }
};
