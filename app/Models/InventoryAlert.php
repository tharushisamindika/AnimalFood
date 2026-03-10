<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryAlert extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'product_id',
        'batch_id',
        'type',
        'priority',
        'title',
        'message',
        'data',
        'status',
        'assigned_to',
        'acknowledged_by',
        'acknowledged_at',
        'resolved_by',
        'resolved_at',
        'resolution_notes',
        'trigger_date',
        'next_check_date',
        'is_recurring',
        'recurrence_rule',
        'email_sent',
        'sms_sent',
        'notification_channels',
        'last_notification_sent',
    ];

    protected $casts = [
        'data' => 'array',
        'notification_channels' => 'array',
        'acknowledged_at' => 'datetime',
        'resolved_at' => 'datetime',
        'trigger_date' => 'datetime',
        'next_check_date' => 'datetime',
        'last_notification_sent' => 'datetime',
        'is_recurring' => 'boolean',
        'email_sent' => 'boolean',
        'sms_sent' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(InventoryBatch::class, 'batch_id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function acknowledgedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'acknowledged_by');
    }

    public function resolvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    /**
     * Create various types of alerts
     */
    public static function createLowStockAlert(Product $product): self
    {
        return static::create([
            'product_id' => $product->id,
            'type' => 'low_stock',
            'priority' => $product->stock_quantity <= $product->minimum_stock_level ? 'critical' : 'high',
            'title' => "Low Stock Alert: {$product->name}",
            'message' => "Product {$product->name} (SKU: {$product->sku}) is running low. Current stock: {$product->stock_quantity}, Reorder level: {$product->reorder_level}",
            'data' => [
                'current_stock' => $product->stock_quantity,
                'reorder_level' => $product->reorder_level,
                'minimum_level' => $product->minimum_stock_level,
            ],
            'trigger_date' => now(),
        ]);
    }

    public static function createExpiryAlert(InventoryBatch $batch, bool $isExpired = false): self
    {
        $type = $isExpired ? 'expired' : 'expiry_warning';
        $priority = $isExpired ? 'critical' : 'high';
        $daysText = $isExpired ? 'has expired' : "expires in {$batch->days_until_expiry} days";

        return static::create([
            'product_id' => $batch->product_id,
            'batch_id' => $batch->id,
            'type' => $type,
            'priority' => $priority,
            'title' => "Expiry Alert: {$batch->product->name}",
            'message' => "Batch {$batch->batch_number} of {$batch->product->name} {$daysText}. Quantity: {$batch->quantity_remaining}",
            'data' => [
                'batch_number' => $batch->batch_number,
                'expiry_date' => $batch->expiry_date,
                'quantity_remaining' => $batch->quantity_remaining,
                'days_until_expiry' => $batch->days_until_expiry,
            ],
            'trigger_date' => now(),
        ]);
    }

    public static function createReorderAlert(Product $product): self
    {
        return static::create([
            'product_id' => $product->id,
            'type' => 'reorder_point',
            'priority' => 'medium',
            'title' => "Reorder Alert: {$product->name}",
            'message' => "Product {$product->name} has reached reorder point. Current stock: {$product->stock_quantity}, Reorder level: {$product->reorder_level}",
            'data' => [
                'current_stock' => $product->stock_quantity,
                'reorder_level' => $product->reorder_level,
                'suggested_order_quantity' => $product->max_stock_level - $product->stock_quantity,
            ],
            'trigger_date' => now(),
        ]);
    }

    public static function createZeroStockAlert(Product $product): self
    {
        return static::create([
            'product_id' => $product->id,
            'type' => 'zero_stock',
            'priority' => 'critical',
            'title' => "Out of Stock: {$product->name}",
            'message' => "Product {$product->name} (SKU: {$product->sku}) is out of stock. Immediate action required.",
            'data' => [
                'current_stock' => $product->stock_quantity,
                'last_stock_update' => $product->last_stock_update,
            ],
            'trigger_date' => now(),
        ]);
    }

    /**
     * Alert actions
     */
    public function acknowledge($userId = null): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        $this->update([
            'status' => 'acknowledged',
            'acknowledged_by' => $userId ?? auth()->id(),
            'acknowledged_at' => now(),
        ]);

        return true;
    }

    public function resolve($notes = null, $userId = null): bool
    {
        if (!in_array($this->status, ['active', 'acknowledged'])) {
            return false;
        }

        $this->update([
            'status' => 'resolved',
            'resolved_by' => $userId ?? auth()->id(),
            'resolved_at' => now(),
            'resolution_notes' => $notes,
        ]);

        return true;
    }

    public function dismiss($userId = null): bool
    {
        $this->update([
            'status' => 'dismissed',
            'resolved_by' => $userId ?? auth()->id(),
            'resolved_at' => now(),
        ]);

        return true;
    }

    /**
     * Helper methods
     */
    public function getFormattedTypeAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->type));
    }

    public function getFormattedPriorityAttribute(): string
    {
        return ucfirst($this->priority);
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->trigger_date && $this->trigger_date->isPast() && $this->status === 'active';
    }

    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'low' => 'blue',
            'medium' => 'yellow',
            'high' => 'orange',
            'critical' => 'red',
            default => 'gray',
        };
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOverdue($query)
    {
        return $query->where('trigger_date', '<', now())
                     ->where('status', 'active');
    }

    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    public function scopeCritical($query)
    {
        return $query->where('priority', 'critical');
    }
}