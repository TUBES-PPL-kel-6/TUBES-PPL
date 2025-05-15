<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanPayment extends Model
{
    protected $fillable = [
        'loan_application_id',
        'amount',
        'installment_number',
        'payment_date',
        'due_date',
        'payment_method',
        'payment_proof',
        'status',
        'notes'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'due_date' => 'date',
    ];

    public function loanApplication()
    {
        return $this->belongsTo(LoanApplication::class);
    }
}
