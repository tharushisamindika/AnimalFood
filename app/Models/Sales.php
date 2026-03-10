<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'quantity',
        'unit_price',
        'total_amount',
        'type',
        'status',
        'notes',
        'original_sale_id',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function originalSale(): BelongsTo
    {
        return $this->belongsTo(Sales::class, 'original_sale_id');
    }

    public function refunds(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Sales::class, 'original_sale_id')->where('type', 'refund');
    }

    public function corrections(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Sales::class, 'original_sale_id')->where('type', 'correction');
    }

    // Scopes
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Helper methods
    public function isRefund(): bool
    {
        return $this->type === 'refund';
    }

    public function isCorrection(): bool
    {
        return $this->type === 'correction';
    }

    public function isOriginalSale(): bool
    {
        return $this->type === 'sale' && !$this->original_sale_id;
    }

    public function getNetAmount(): float
    {
        if ($this->isRefund()) {
            return -$this->total_amount;
        }
        return $this->total_amount;
    }

    public function canBeRefunded(): bool
    {
        return $this->isOriginalSale() && $this->status === 'completed';
    }

    public function canBeCorrected(): bool
    {
        return $this->isOriginalSale() && $this->status === 'completed';
    }
}
