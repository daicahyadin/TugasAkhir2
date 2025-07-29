<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promo extends Model
{
    protected $fillable = [
        'title',
        'description',
        'discount_percentage',
        'start_date',
        'end_date',
        'is_active',
        'image',
        'terms_conditions',
        'minimum_purchase',
        'maximum_discount',
        'type',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'discount_percentage' => 'decimal:2',
        'minimum_purchase' => 'decimal:2',
        'maximum_discount' => 'decimal:2'
    ];

    // Relasi ke mobil
    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    /**
     * Get the type label for display.
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'promo' => 'Promo',
            'event' => 'Event',
            'news' => 'Berita',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Check if promo is currently active.
     */
    public function isCurrentlyActive(): bool
    {
        return $this->is_active && 
               $this->start_date <= now() && 
               $this->end_date >= now();
    }

    /**
     * Get the formatted discount percentage.
     */
    public function getFormattedDiscountAttribute(): string
    {
        return $this->discount_percentage . '%';
    }

    /**
     * Get the formatted minimum purchase.
     */
    public function getFormattedMinimumPurchaseAttribute(): string
    {
        return 'Rp ' . number_format($this->minimum_purchase, 0, ',', '.');
    }

    /**
     * Get the formatted maximum discount.
     */
    public function getFormattedMaximumDiscountAttribute(): string
    {
        return 'Rp ' . number_format($this->maximum_discount, 0, ',', '.');
    }
}
