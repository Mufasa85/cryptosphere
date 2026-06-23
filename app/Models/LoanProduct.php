<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'min_amount',
        'max_amount',
        'interest_rate',
        'duration_months',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'min_amount'       => 'decimal:2',
            'max_amount'       => 'decimal:2',
            'interest_rate'    => 'decimal:2',
            'duration_months'  => 'integer',
            'is_active'        => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
