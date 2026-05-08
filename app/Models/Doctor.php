<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'user_id', 'department_id', 'name', 'email', 'phone',
        'specialization', 'qualification', 'experience_years',
        'bio', 'image', 'consultation_fee', 'availability', 'status',
        'employee_id', 'gender', 'dob', 'blood_group', 'address', 'joining_date',
    ];

        /**
         * @property int $id
         * @property string|null $phone
         */

    protected function casts(): array
    {
        return [
            'availability' => 'array',
            'consultation_fee' => 'decimal:2',
            'dob' => 'date',
            'joining_date' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }
}
