<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'name', 'category', 'manufacturer', 'unit_price',
        'stock_quantity', 'reorder_level', 'expiry_date', 'status',
    ];

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'expiry_date' => 'date',
        ];
    }

    public function prescriptionItems()
    {
        return $this->hasMany(PrescriptionItem::class);
    }
}
