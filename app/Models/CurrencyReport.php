<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyReport extends Model
{
    use HasFactory;
    protected $table = 'currency_report';

    protected $casts = [
        'result' => 'json',
    ];
}
