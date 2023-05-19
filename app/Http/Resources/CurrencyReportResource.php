<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use App\Models\CurrencyReport;

/**
 * @mixin CurrencyReport
 */
class CurrencyReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reportUid' => $this->report_uid,
            'currency' => $this->currency,
            'result' => $this->result,
            'createdAt' => $this->created_at
        ];
    }
}
