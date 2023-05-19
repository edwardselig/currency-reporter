<?php

namespace App\Http\Controllers;

use App\Repository\CurrencyConverterRepository;
use App\Http\Controllers\Controller;

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
        return response()->json((new CurrencyConverterRepository)->conversions());
    }

    public function timeframe()
    {
        //return response()->json((new CurrencyConverterRepository)->timeframe());
    }
}
