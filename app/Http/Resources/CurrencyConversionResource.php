<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use App\Models\CurrencyConversion;

/**
 * @mixin CurrencyConversion
 */
class CurrencyConversionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'abbreviationPair' => $this->abbreviation_pair,
            'convertFrom' => $this->convert_from,
            'convertTo' => $this->convert_to,
            'value' => $this->value,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
