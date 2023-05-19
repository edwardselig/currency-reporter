<?php

namespace App\Http\Requests\Currencies\Queue;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    //fix authorize
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'report_uid' => 'required|string|exists:App\Models\CurrencyReportType,uid',
            'currency' => 'required|string|exists:App\Models\Currency,abbreviation'
        ];
    }
}
