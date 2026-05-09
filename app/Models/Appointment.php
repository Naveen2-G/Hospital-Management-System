<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int|null $doctor_id
 * @property int|null $patient_id
 */
class Appointment extends Model
{
    protected $fillable = [
        'patient_id', 'doctor_id', 'department_id',
        'appointment_date', 'time_slot', 'status', 'type', 'notes',
        'guest_name', 'guest_phone',
    ];

    public function getPatientNameAttribute()
    {
        if ($this->patient) {
            return $this->patient->name ?? $this->patient->user?->name ?? 'Unknown Patient';
        }
        return $this->guest_name ? $this->guest_name . ' (Guest User)' : 'Unknown Patient';
    }

    protected function casts(): array
    {
        return ['appointment_date' => 'date'];
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
