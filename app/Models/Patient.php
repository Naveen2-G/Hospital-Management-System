<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'user_id', 'name', 'email', 'phone', 'dob', 'gender',
        'blood_group', 'address', 'emergency_contact', 'emergency_contact_name',
        'allergies', 'chronic_diseases', 'avatar',
    ];

    protected function casts(): array
    {
        return ['dob' => 'date'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function labOrders()
    {
        return $this->hasMany(LabOrder::class);
    }
}
