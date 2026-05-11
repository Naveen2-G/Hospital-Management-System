<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthPackageBooking extends Model
{
    protected $fillable = [
        'user_id',
        'patient_name',
        'phone',
        'email',
        'gender',
        'age',
        'address',
        'city',
        'state',
        'pincode',
        'preferred_date',
        'preferred_time_slot',
        'package_name',
        'package_price',
        'notes',
        'payment_method',
        'payment_status',
        'booking_status',
        'transaction_id',
    ];

    protected function casts(): array
    {
        return [
            'preferred_date' => 'date',
            'package_price' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
