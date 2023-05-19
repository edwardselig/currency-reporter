<?php

namespace App\Http\Controllers;

use App\Repository\CurrencyConverterRepository;
use App\Http\Controllers\Controller;
use App\Http\Resources\CurrencyConversionResource;
use App\Models\CurrencyConversion;

class CurrencyConverterController extends Controller
{
    public function __construct()
    {
    }

    public function list()
    {
        return response()->json((new CurrencyConverterRepository)->list());
    }

    public function conversions()
    {
        return CurrencyConversionResource::collection(CurrencyConversion::all());
    }
}
