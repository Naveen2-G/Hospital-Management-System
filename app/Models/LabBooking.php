<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabBooking extends Model
{
    use HasFactory;

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
        'test_name',
        'test_price',
        'notes',
        'payment_method',
        'payment_status',
        'booking_status',
        'transaction_id',
        'report_file',
        'report_uploaded_at',
        'admin_remarks',
        'patient_id',
        'package_id',
    ];

    protected function casts(): array
    {
        return [
            'preferred_date' => 'date',
            'test_price' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
