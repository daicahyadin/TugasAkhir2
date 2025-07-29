<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Car extends Model
{
    // Daftar kolom yang boleh diisi massal
    protected $fillable = [
        'name',
        'brand',
        'model',
        'year',
        'type',
        'price',
        'stock',
        'description',
        'specifications',
        'image',
        'promo_id'
    ];

    protected $casts = [
        'specifications' => 'array',
        'price' => 'decimal:2'
    ];

    // Relasi ke test drive
    public function testDrives(): HasMany
    {
        return $this->hasMany(TestDrive::class);
    }

    // Relasi ke pembelian
    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    // Relasi ke promo
    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }

    /**
     * Get the formatted price.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get the discounted price if promo exists.
     */
    public function getDiscountedPriceAttribute(): ?float
    {
        if ($this->promo && $this->promo->is_active) {
            $discount = ($this->price * $this->promo->discount_percentage) / 100;
            if ($this->promo->maximum_discount && $discount > $this->promo->maximum_discount) {
                $discount = $this->promo->maximum_discount;
            }
            return $this->price - $discount;
        }
        return null;
    }

    /**
     * Get the formatted discounted price.
     */
    public function getFormattedDiscountedPriceAttribute(): ?string
    {
        if ($discountedPrice = $this->discounted_price) {
            return 'Rp ' . number_format($discountedPrice, 0, ',', '.');
        }
        return null;
    }

    /**
     * Check if car has active promo.
     */
    public function hasActivePromo(): bool
    {
        return $this->promo && $this->promo->is_active && 
               $this->promo->start_date <= now() && 
               $this->promo->end_date >= now();
    }
}

