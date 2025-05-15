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
    
    public function payments()
    {
        return $this->hasMany(LoanPayment::class);
    }
    
    public function getMonthlyInstallmentAmount()
    {
        // Simple calculation (loan amount / tenor)
        // In a real application, you would include interest calculation
        return $this->loan_amount / $this->tenor;
    }
    
    public function getRemainingBalance()
    {
        $paidAmount = $this->payments()->where('status', 'paid')->sum('amount');
        return $this->loan_amount - $paidAmount;
    }
}
