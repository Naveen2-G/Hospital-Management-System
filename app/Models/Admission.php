<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $fillable = [
        'patient_id', 'doctor_id', 'bed_id',
        'admission_date', 'discharge_date', 'type',
        'diagnosis', 'notes', 'status',
    ];

    protected function casts(): array
    {
        return [
            'admission_date' => 'date',
            'discharge_date' => 'date',
        ];
    }

    public function patient() { return $this->belongsTo(Patient::class); }
    public function doctor()  { return $this->belongsTo(Doctor::class); }
    public function bed()     { return $this->belongsTo(Bed::class); }
}
