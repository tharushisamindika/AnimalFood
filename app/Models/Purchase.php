<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'purchase_number',
        'invoice_number',
        'supplier_id',
        'user_id',
        'purchase_date',
        'delivery_date',
        'expected_delivery_date',
        'status',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'shipping_cost',
        'total_amount',
        'notes',
        'terms_conditions',
        'payment_status',
        'payment_due_date',
        'attachments',
        'received_at',
        'received_by',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'delivery_date' => 'date',
        'expected_delivery_date' => 'date',
        'payment_due_date' => 'date',
        'received_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'attachments' => 'array',
    ];

    /**
     * Generate the next purchase number
     */
    public static function generatePurchaseNumber()
    {
        $lastPurchase = self::orderBy('id', 'desc')->first();
        $lastNumber = $lastPurchase ? (int) substr($lastPurchase->purchase_number, 4) : 0;
        $nextNumber = $lastNumber + 1;
        return 'PUR-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Relationships
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function returns(): HasMany
    {
        return $this->hasMany(PurchaseReturn::class);
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
        return $query->whereBetween('purchase_date', [$startDate, $endDate]);
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['pending', 'partial']);
    }

    public function scopeOverdue($query)
    {
        return $query->where('payment_status', 'pending')
                    ->where('payment_due_date', '<', now());
    }

    /**
     * Helper methods
     */
    public function getTotalQuantityOrderedAttribute()
    {
        return $this->items->sum('quantity_ordered');
    }

    public function getTotalQuantityReceivedAttribute()
    {
        return $this->items->sum('quantity_received');
    }

    public function getTotalQuantityPendingAttribute()
    {
        return $this->items->sum('quantity_pending');
    }

    public function getIsOverdueAttribute()
    {
        return $this->payment_due_date && 
               $this->payment_status === 'pending' && 
               $this->payment_due_date->isPast();
    }

    public function getCanBeReceivedAttribute()
    {
        return in_array($this->status, ['pending', 'partial']);
    }

    public function getCanBeCancelledAttribute()
    {
        return in_array($this->status, ['pending', 'partial']);
    }

    public function getFormattedStatusAttribute()
    {
        return ucfirst($this->status);
    }

    public function getFormattedPaymentStatusAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->payment_status));
    }

    /**
     * Update purchase totals based on items
     */
    public function updateTotals()
    {
        $this->subtotal = $this->items->sum('total_cost');
        $this->total_amount = $this->subtotal + $this->tax_amount + $this->shipping_cost - $this->discount_amount;
        $this->save();
    }

    /**
     * Update purchase status based on items
     */
    public function updateStatus()
    {
        $totalOrdered = $this->total_quantity_ordered;
        $totalReceived = $this->total_quantity_received;

        if ($totalReceived == 0) {
            $this->status = 'pending';
        } elseif ($totalReceived < $totalOrdered) {
            $this->status = 'partial';
        } elseif ($totalReceived == $totalOrdered) {
            $this->status = 'received';
        }

        // Update individual item statuses
        foreach ($this->items as $item) {
            if ($item->quantity_received == 0) {
                $item->status = 'pending';
            } elseif ($item->quantity_received < $item->quantity_ordered) {
                $item->status = 'partial';
            } elseif ($item->quantity_received == $item->quantity_ordered) {
                $item->status = 'received';
            }
            $item->quantity_pending = $item->quantity_ordered - $item->quantity_received;
            $item->save();
        }

        $this->save();
    }

    /**
     * Receive items for this purchase
     */
    public function receiveItems(array $receivedItems, $receivedBy = null)
    {
        \DB::transaction(function () use ($receivedItems, $receivedBy) {
            foreach ($receivedItems as $itemData) {
                $item = $this->items()->find($itemData['item_id']);
                if ($item) {
                    $quantityToReceive = min($itemData['quantity'], $item->quantity_pending);
                    
                    if ($quantityToReceive > 0) {
                        // Update purchase item
                        $item->increment('quantity_received', $quantityToReceive);
                        $item->decrement('quantity_pending', $quantityToReceive);
                        
                        // Update product stock
                        $item->product->increment('stock_quantity', $quantityToReceive);
                        
                        // Create inventory transaction
                        InventoryTransaction::create([
                            'product_id' => $item->product_id,
                            'user_id' => $receivedBy ?? auth()->id(),
                            'type' => 'in',
                            'quantity' => $quantityToReceive,
                            'reason' => 'Purchase received',
                            'reference_number' => $this->purchase_number,
                        ]);
                    }
                }
            }

            // Update purchase status
            $this->updateStatus();

            // Mark as received if all items are received
            if ($this->status === 'received') {
                $this->received_at = now();
                $this->received_by = $receivedBy ?? auth()->id();
                $this->save();
            }
        });
    }
}