<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'patient_id', 'invoice_number', 'total_amount',
        'paid_amount', 'due_amount', 'status', 'due_date',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'due_amount' => 'decimal:2',
            'due_date' => 'date',
        ];
    }

    public function patient() { return $this->belongsTo(Patient::class); }
    public function items()   { return $this->hasMany(InvoiceItem::class); }
    public function payments(){ return $this->hasMany(Payment::class); }
}
