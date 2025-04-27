<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    protected $fillable = [
        'loan_product',
        'application_note',
        'loan_amount',
        'tenor',
        'application_date',
        'first_payment_date',
        'payment_method',
        'collateral',
        'documents'
    ];

    protected $casts = [
        'application_date' => 'date',
        'first_payment_date' => 'date',
        'documents' => 'array'
    ];
}