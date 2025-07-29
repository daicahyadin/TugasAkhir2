<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestDrive extends Model
{
    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'user_id',
        'car_id',
        'phone',
        'preferred_date',
        'preferred_time',
        'status',
        'notes',
        'admin_notes',
        'ticket_code',
        'processed_at',
        'processed_by'
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'preferred_time' => 'string',
        'processed_at' => 'datetime'
    ];

    /**
     * Get the user that owns the test drive.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the car for the test drive.
     */
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Get the admin who processed this test drive.
     */
    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
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
     * Generate ticket code for the test drive.
     */
    public static function generateTicketCode(): string
    {
        do {
            $code = 'TD-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));
        } while (self::where('ticket_code', $code)->exists());
        
        return $code;
    }
}

