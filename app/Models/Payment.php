<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'invoice_id', 'amount', 'payment_method', 'payment_date', 'transaction_id', 'notes'
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function getPaymentMethodLabelAttribute()
    {
        return match($this->payment_method) {
            'cash' => 'Espèces',
            'card' => 'Carte bancaire',
            'check' => 'Chèque',
            'transfer' => 'Virement',
            default => $this->payment_method,
        };
    }
}