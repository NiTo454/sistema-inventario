<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'description',
        'price',
        'cost',
        'stock',
        'min_stock',
        'category',
        'brand',
        'unit',
        'location',
        'is_active',
        'image'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relaciones
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    // Métodos
    public function isLowStock()
    {
        return $this->stock <= $this->min_stock;
    }

    public function getStockStatusAttribute()
    {
        if ($this->stock <= 0) {
            return ['status' => 'Agotado', 'class' => 'danger'];
        } elseif ($this->stock <= $this->min_stock) {
            return ['status' => 'Bajo', 'class' => 'warning'];
        } else {
            return ['status' => 'Disponible', 'class' => 'success'];
        }
    }

    public function getProfitMarginAttribute()
    {
        if (!$this->cost || $this->cost == 0) {
            return 0;
        }
        return (($this->price - $this->cost) / $this->cost) * 100;
    }

    public function updateStock($quantity)
    {
        $this->stock += $quantity;
        if ($this->stock < 0) {
            $this->stock = 0;
        }
        $this->save();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock', '<=', 'min_stock');
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('stock', '<=', 0);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
    }
}
