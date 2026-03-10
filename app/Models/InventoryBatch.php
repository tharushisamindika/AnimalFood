<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class InventoryBatch extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'product_id',
        'batch_number',
        'lot_number',
        'quantity_received',
        'quantity_remaining',
        'quantity_allocated',
        'unit_cost',
        'selling_price',
        'received_date',
        'manufacture_date',
        'expiry_date',
        'best_before_date',
        'supplier_id',
        'purchase_id',
        'invoice_number',
        'quality_status',
        'storage_location',
        'quality_notes',
        'received_by',
        'is_active',
        'last_movement',
    ];

    protected $casts = [
        'received_date' => 'date',
        'manufacture_date' => 'date',
        'expiry_date' => 'date',
        'best_before_date' => 'date',
        'unit_cost' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'is_active' => 'boolean',
        'last_movement' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function inventoryTransactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class, 'batch_id');
    }

    public function alerts(): HasMany
    {
        return $this->hasMany(InventoryAlert::class, 'batch_id');
    }

    /**
     * Generate unique batch number
     */
    public static function generateBatchNumber($productId)
    {
        $product = Product::find($productId);
        $prefix = $product ? strtoupper(substr($product->sku, 0, 3)) : 'BTH';
        $date = now()->format('ymd');
        $sequence = static::where('batch_number', 'like', $prefix . $date . '%')->count() + 1;
        
        return $prefix . $date . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Check if batch is expired
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    /**
     * Check if batch is expiring soon
     */
    public function getIsExpiringSoonAttribute(): bool
    {
        if (!$this->expiry_date) return false;
        
        $alertDays = $this->product->expiry_alert_days ?? 30;
        return $this->expiry_date->diffInDays(now()) <= $alertDays;
    }

    /**
     * Get available quantity (remaining - allocated)
     */
    public function getAvailableQuantityAttribute(): int
    {
        return max(0, $this->quantity_remaining - $this->quantity_allocated);
    }

    /**
     * Get total value of batch
     */
    public function getTotalValueAttribute(): float
    {
        return $this->quantity_remaining * $this->unit_cost;
    }

    /**
     * Get age of batch in days
     */
    public function getAgeDaysAttribute(): int
    {
        return $this->received_date->diffInDays(now());
    }

    /**
     * Get days until expiry
     */
    public function getDaysUntilExpiryAttribute(): ?int
    {
        return $this->expiry_date ? now()->diffInDays($this->expiry_date, false) : null;
    }

    /**
     * Reduce batch quantity
     */
    public function reduceQuantity(int $quantity, string $reason = null): bool
    {
        if ($this->available_quantity < $quantity) {
            return false;
        }

        $this->decrement('quantity_remaining', $quantity);
        $this->last_movement = now();
        $this->save();

        // Create inventory transaction
        InventoryTransaction::create([
            'product_id' => $this->product_id,
            'batch_id' => $this->id,
            'user_id' => auth()->id(),
            'type' => 'out',
            'quantity' => $quantity,
            'unit_cost' => $this->unit_cost,
            'total_cost' => $quantity * $this->unit_cost,
            'reason' => $reason ?? 'Batch quantity reduction',
            'transaction_date' => now(),
            'is_automatic' => true,
        ]);

        return true;
    }

    /**
     * Allocate quantity for orders
     */
    public function allocateQuantity(int $quantity): bool
    {
        if ($this->available_quantity < $quantity) {
            return false;
        }

        $this->increment('quantity_allocated', $quantity);
        return true;
    }

    /**
     * Release allocated quantity
     */
    public function releaseAllocation(int $quantity): bool
    {
        if ($this->quantity_allocated < $quantity) {
            return false;
        }

        $this->decrement('quantity_allocated', $quantity);
        return true;
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeExpired($query)
    {
        return $query->where('expiry_date', '<', now());
    }

    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->where('expiry_date', '<=', now()->addDays($days))
                     ->where('expiry_date', '>', now());
    }

    public function scopeAvailable($query)
    {
        return $query->active()
                     ->whereRaw('quantity_remaining > quantity_allocated');
    }

    public function scopeByProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    public function scopeFifo($query)
    {
        return $query->orderBy('received_date', 'asc');
    }

    public function scopeLifo($query)
    {
        return $query->orderBy('received_date', 'desc');
    }

    public function scopeByExpiry($query, $oldest = true)
    {
        return $query->orderBy('expiry_date', $oldest ? 'asc' : 'desc');
    }
}