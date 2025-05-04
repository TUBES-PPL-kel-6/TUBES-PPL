<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    protected $fillable = [
        'user_id',
        'loan_product',
        'application_note',
        'loan_amount',
        'tenor',
        'application_date',
        'first_payment_date',
        'payment_method',
        'collateral',
        'documents',
        'status'
    ];

    protected $casts = [
        'application_date' => 'date',
        'first_payment_date' => 'date',
        'documents' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
