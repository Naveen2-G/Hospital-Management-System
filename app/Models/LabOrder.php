<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabOrder extends Model
{
    protected $fillable = [
        'patient_id', 'doctor_id', 'lab_test_id', 'technician_id',
        'status', 'result', 'report_file', 'ordered_at', 'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'ordered_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function patient()   { return $this->belongsTo(Patient::class); }
    public function doctor()    { return $this->belongsTo(Doctor::class); }
    public function labTest()   { return $this->belongsTo(LabTest::class); }
    public function technician(){ return $this->belongsTo(User::class, 'technician_id'); }
}
