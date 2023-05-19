<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessReport;
use App\Models\CurrencyReportType;
use App\Http\Requests\Currencies\Queue\StoreRequest;
use App\Models\CurrencyReport;
use App\Http\Resources\CurrencyReportResource;

class CurrencyQueueController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        return CurrencyReportResource::collection(CurrencyReport::all());
    }

    public function show(CurrencyReport $currencyReport)
    {
        return response()->json($currencyReport->result);
    }

    public function store(StoreRequest $request)
    {
        $currencyReport = new CurrencyReport;
        $currencyReport->report_uid = $request->safe()->report_uid;
        $currencyReport->currency = $request->safe()->currency;
        $currencyReport->save();
        ProcessReport::dispatch($currencyReport);
        return response([], 201);
    }
}
