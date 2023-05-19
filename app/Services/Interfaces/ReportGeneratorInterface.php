<?php

namespace App\Services\Interfaces;

use Illuminate\Support\Carbon;

interface ReportGeneratorInterface
{
    public function getReport(): array;
}
