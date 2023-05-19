<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Services\CurrencyConverterApi;
use Illuminate\Database\Seeder;
use App\Models\Currency;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $api = new CurrencyConverterApi;
        $list = $api->list();
        DB::transaction(function () use ($list) {
            Currency::truncate();
            foreach ($list['currencies'] as $abbreviation => $name) {
                $currency = new Currency;
                $currency->name = $name;
                $currency->abbreviation = $abbreviation;
                $currency->save();
            }
        });
    }
}
