<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Purchase extends Model
{
    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'user_id',
        'car_id',
        'promo_id',
        'payment_method',
        'ktp_photo',
        'npwp_photo',
        'team',
        'status',
        'whatsapp_number',
        'original_price',
        'discount_amount',
        'total_price',
        'down_payment',
        'loan_term',
        'notes',
        'admin_notes',
        'ticket_code',
        'processed_at',
        'processed_by'
    ];

    protected $casts = [
        'original_price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_price' => 'decimal:2',
        'down_payment' => 'decimal:2',
        'processed_at' => 'datetime'
    ];

    /**
     * Get the user that owns the purchase.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the car that was purchased.
     */
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Get the promo applied to this purchase.
     */
    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }

    /**
     * Get the admin who processed this purchase.
     */
    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Get the STNK record for this purchase.
     */
    public function stnk(): HasOne
    {
        return $this->hasOne(Stnk::class);
    }

    /**
     * Get the status label for display.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu Approval',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'completed' => 'Selesai',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Get the status badge class for styling.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-blue-100 text-blue-800',
            'rejected' => 'bg-red-100 text-red-800',
            'completed' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Generate ticket code for the purchase.
     */
    public static function generateTicketCode(): string
    {
        do {
            $code = 'PUR-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));
        } while (self::where('ticket_code', $code)->exists());
        
        return $code;
    }
}

