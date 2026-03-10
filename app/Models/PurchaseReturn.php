<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseReturn extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'return_number',
        'purchase_id',
        'purchase_item_id',
        'product_id',
        'supplier_id',
        'user_id',
        'return_date',
        'quantity_returned',
        'unit_cost',
        'total_amount',
        'reason',
        'reason_description',
        'status',
        'refund_method',
        'refund_date',
        'refund_amount',
        'notes',
        'attachments',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'return_date' => 'date',
        'refund_date' => 'date',
        'approved_at' => 'datetime',
        'unit_cost' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
        'attachments' => 'array',
    ];

    /**
     * Generate the next return number
     */
    public static function generateReturnNumber()
    {
        $lastReturn = self::orderBy('id', 'desc')->first();
        $lastNumber = $lastReturn ? (int) substr($lastReturn->return_number, 4) : 0;
        $nextNumber = $lastNumber + 1;
        return 'RET-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Relationships
     */
    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function purchaseItem(): BelongsTo
    {
        return $this->belongsTo(PurchaseItem::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($return) {
            // Calculate total amount
            $return->total_amount = $return->unit_cost * $return->quantity_returned;
        });

        static::created(function ($return) {
            // Automatically set initial refund amount
            if (!$return->refund_amount) {
                $return->refund_amount = $return->total_amount;
                $return->save();
            }
        });
    }

    /**
     * Scopes
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeBySupplier($query, $supplierId)
    {
        return $query->where('supplier_id', $supplierId);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('return_date', [$startDate, $endDate]);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->whereIn('status', ['approved', 'processed', 'completed']);
    }

    /**
     * Helper methods
     */
    public function getFormattedStatusAttribute()
    {
        return ucfirst($this->status);
    }

    public function getFormattedReasonAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->reason));
    }

    public function getFormattedRefundMethodAttribute()
    {
        return $this->refund_method ? ucfirst(str_replace('_', ' ', $this->refund_method)) : null;
    }

    public function getCanBeApprovedAttribute()
    {
        return $this->status === 'pending';
    }

    public function getCanBeProcessedAttribute()
    {
        return $this->status === 'approved';
    }

    public function getIsProcessedAttribute()
    {
        return in_array($this->status, ['processed', 'completed']);
    }

    /**
     * Approve the return
     */
    public function approve($approvedBy = null)
    {
        $this->update([
            'status' => 'approved',
            'approved_by' => $approvedBy ?? auth()->id(),
            'approved_at' => now(),
        ]);

        return $this;
    }

    /**
     * Process the return (reduce inventory)
     */
    public function process()
    {
        \DB::transaction(function () {
            // Reduce product stock
            $this->product->decrement('stock_quantity', $this->quantity_returned);

            // Create inventory transaction
            InventoryTransaction::create([
                'product_id' => $this->product_id,
                'user_id' => auth()->id(),
                'type' => 'out',
                'quantity' => $this->quantity_returned,
                'reason' => 'Purchase return - ' . $this->formatted_reason,
                'reference_number' => $this->return_number,
            ]);

            // Update status
            $this->update(['status' => 'processed']);
        });

        return $this;
    }

    /**
     * Mark as completed with refund details
     */
    public function complete($refundMethod, $refundAmount = null, $refundDate = null)
    {
        $this->update([
            'status' => 'completed',
            'refund_method' => $refundMethod,
            'refund_amount' => $refundAmount ?? $this->total_amount,
            'refund_date' => $refundDate ?? now(),
        ]);

        return $this;
    }
}