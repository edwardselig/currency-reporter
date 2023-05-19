<?php

namespace App\Exceptions;

use Exception;

class CurrencyApiException extends Exception
{
    public function render()
    {
        return response()->json(['message' => $this->getMessage(), 503]);
    }
}
