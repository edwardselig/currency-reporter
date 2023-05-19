<?php

namespace Database\Seeders;

use App\Models\CurrencyConversion;
use Illuminate\Database\Seeder;
use App\Services\CurrencyConverterApi;
use Illuminate\Support\Facades\DB;

class CurrencyConversionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $api = new CurrencyConverterApi;
        $conversions = $api->live();
        DB::transaction(function () use ($conversions) {
            foreach ($conversions['quotes'] as $abbreviationPair => $value) {
                $currencyConversion = CurrencyConversion::where('abbreviation_pair', '=', $abbreviationPair)->first() ?? new CurrencyConversion();
                $this->saveCurrencyConvertion($currencyConversion, $abbreviationPair, $value);
            }
        });
    }

    protected function saveCurrencyConvertion(CurrencyConversion $currencyConversion, string $abbreviationPair, float $value)
    {
        [$convertFrom, $convertTo] = $this->splitAbbreviationPair($abbreviationPair);
        $currencyConversion->abbreviation_pair = $abbreviationPair;
        $currencyConversion->convert_to = $convertTo;
        $currencyConversion->convert_from = $convertFrom;
        $currencyConversion->value = $value;
        $currencyConversion->save();
    }

    protected function splitAbbreviationPair(string $abbreviationPair): array
    {
        return str_split($abbreviationPair, 3);
    }
}
