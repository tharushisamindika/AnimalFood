<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseItem extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'purchase_id',
        'product_id',
        'unit_cost',
        'quantity_ordered',
        'quantity_received',
        'quantity_pending',
        'total_cost',
        'expiry_date',
        'batch_number',
        'notes',
        'status',
    ];

    protected $casts = [
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'expiry_date' => 'date',
    ];

    /**
     * Relationships
     */
    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            // Calculate total cost
            $item->total_cost = $item->unit_cost * $item->quantity_ordered;
            
            // Calculate pending quantity
            $item->quantity_pending = $item->quantity_ordered - $item->quantity_received;
        });

        static::saved(function ($item) {
            // Update purchase totals when item is saved
            $item->purchase->updateTotals();
        });
    }

    /**
     * Helper methods
     */
    public function getFormattedStatusAttribute()
    {
        return ucfirst($this->status);
    }

    public function getReceivePercentageAttribute()
    {
        if ($this->quantity_ordered == 0) return 0;
        return round(($this->quantity_received / $this->quantity_ordered) * 100, 2);
    }

    public function getCanReceiveMoreAttribute()
    {
        return $this->quantity_pending > 0;
    }

    public function getIsExpiredAttribute()
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    public function getIsExpiringSoonAttribute($days = 30)
    {
        if (!$this->expiry_date) return false;
        return $this->expiry_date->diffInDays(now()) <= $days;
    }
}