<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['room_number', 'type', 'floor', 'capacity', 'rate_per_day', 'status'];

    protected function casts(): array
    {
        return ['rate_per_day' => 'decimal:2'];
    }

    public function beds()
    {
        return $this->hasMany(Bed::class);
    }

    public function availableBeds()
    {
        return $this->hasMany(Bed::class)->where('status', 'available');
    }
}
