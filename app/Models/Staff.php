<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';

    protected $fillable = [
        'user_id', 'name', 'email', 'phone',
        'designation', 'department_id', 'joining_date', 'salary', 'status',
    ];

    protected function casts(): array
    {
        return ['joining_date' => 'date', 'salary' => 'decimal:2'];
    }

    public function user()       { return $this->belongsTo(User::class); }
    public function department() { return $this->belongsTo(Department::class); }
}
