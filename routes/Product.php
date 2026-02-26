<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'is_active',
    ];

    /**
     * Relación muchos a muchos con Ventas.
     */
    public function sales(): BelongsToMany
    {
        return $this->belongsToMany(Sale::class)
                    ->withPivot('quantity', 'price_at_sale')
                    ->withTimestamps();
    }
}