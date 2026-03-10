<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'name',
        'description',
        'category',
        'category_id',
        'brand',
        'price',
        'cost_price',
        'stock_quantity',
        'reorder_level',
        'max_stock_level',
        'minimum_stock_level',
        'stock_method',
        'average_cost',
        'track_batches',
        'track_expiry',
        'low_stock_alert',
        'expiry_alert',
        'expiry_alert_days',
        'reorder_alert',
        'expiry_date',
        'unit',
        'sku',
        'barcode',
        'qr_code',
        'supplier_id',
        'location',
        'storage_conditions',
        'weight',
        'weight_unit',
        'last_stock_update',
        'last_ordered',
        'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'average_cost' => 'decimal:2',
        'weight' => 'decimal:3',
        'track_batches' => 'boolean',
        'track_expiry' => 'boolean',
        'low_stock_alert' => 'boolean',
        'expiry_alert' => 'boolean',
        'reorder_alert' => 'boolean',
        'expiry_date' => 'date',
        'last_stock_update' => 'datetime',
        'last_ordered' => 'datetime',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function inventoryTransactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function purchaseReturns()
    {
        return $this->hasMany(PurchaseReturn::class);
    }

    public function inventoryBatches()
    {
        return $this->hasMany(InventoryBatch::class);
    }

    public function inventoryAlerts()
    {
        return $this->hasMany(InventoryAlert::class);
    }

    public function activeBatches()
    {
        return $this->hasMany(InventoryBatch::class)->active();
    }

    public function availableBatches()
    {
        return $this->hasMany(InventoryBatch::class)->available();
    }

    // Enhanced inventory methods
    public function isLowStock($threshold = null)
    {
        $threshold = $threshold ?? $this->reorder_level ?? 10;
        return $this->stock_quantity <= $threshold;
    }

    public function isAtReorderLevel()
    {
        return $this->stock_quantity <= $this->reorder_level;
    }

    public function isBelowMinimumLevel()
    {
        return $this->stock_quantity <= $this->minimum_stock_level;
    }

    public function isExpiringSoon($days = null)
    {
        if (!$this->expiry_date) {
            return false;
        }
        $days = $days ?? $this->expiry_alert_days ?? 30;
        return $this->expiry_date->diffInDays(now()) <= $days;
    }

    public function isExpired()
    {
        if (!$this->expiry_date) {
            return false;
        }
        return $this->expiry_date->isPast();
    }

    public function hasExpiredBatches()
    {
        return $this->inventoryBatches()->expired()->exists();
    }

    public function hasExpiringSoonBatches($days = null)
    {
        $days = $days ?? $this->expiry_alert_days ?? 30;
        return $this->inventoryBatches()->expiringSoon($days)->exists();
    }

    // Stock allocation methods for FIFO/LIFO
    public function allocateStock($quantity, $method = null)
    {
        $method = $method ?? $this->stock_method ?? 'FIFO';
        
        if (!$this->track_batches) {
            // Simple stock deduction without batch tracking
            if ($this->stock_quantity >= $quantity) {
                $this->decrement('stock_quantity', $quantity);
                $this->last_stock_update = now();
                $this->save();
                return true;
            }
            return false;
        }

        // Batch-based allocation
        $remainingQuantity = $quantity;
        $batches = $this->getAvailableBatchesByMethod($method);

        foreach ($batches as $batch) {
            if ($remainingQuantity <= 0) break;

            $allocateFromBatch = min($remainingQuantity, $batch->available_quantity);
            
            if ($batch->reduceQuantity($allocateFromBatch, 'Sale allocation')) {
                $remainingQuantity -= $allocateFromBatch;
                $this->decrement('stock_quantity', $allocateFromBatch);
            }
        }

        if ($remainingQuantity === 0) {
            $this->last_stock_update = now();
            $this->save();
            $this->checkAndCreateAlerts();
            return true;
        }

        return false; // Not enough stock
    }

    public function getAvailableBatchesByMethod($method = 'FIFO')
    {
        $query = $this->availableBatches();
        
        return match($method) {
            'FIFO' => $query->fifo()->get(),
            'LIFO' => $query->lifo()->get(),
            'FEFO' => $query->byExpiry(true)->get(), // First Expired First Out
            default => $query->fifo()->get(),
        };
    }

    public function receiveStock($quantity, $unitCost, $batchData = [])
    {
        if ($this->track_batches) {
            // Create new batch
            $batch = InventoryBatch::create(array_merge([
                'product_id' => $this->id,
                'batch_number' => InventoryBatch::generateBatchNumber($this->id),
                'quantity_received' => $quantity,
                'quantity_remaining' => $quantity,
                'unit_cost' => $unitCost,
                'received_date' => now(),
                'received_by' => auth()->id(),
            ], $batchData));
        }

        // Update product stock
        $this->increment('stock_quantity', $quantity);
        $this->updateAverageCost($quantity, $unitCost);
        $this->last_stock_update = now();
        $this->save();

        // Create inventory transaction
        InventoryTransaction::create([
            'product_id' => $this->id,
            'batch_id' => isset($batch) ? $batch->id : null,
            'user_id' => auth()->id(),
            'type' => 'in',
            'quantity' => $quantity,
            'unit_cost' => $unitCost,
            'total_cost' => $quantity * $unitCost,
            'reason' => 'Stock received',
            'transaction_date' => now(),
        ]);

        $this->checkAndCreateAlerts();
    }

    public function updateAverageCost($newQuantity, $newCost)
    {
        $currentValue = $this->stock_quantity * $this->average_cost;
        $newValue = $newQuantity * $newCost;
        $totalQuantity = $this->stock_quantity + $newQuantity;
        
        if ($totalQuantity > 0) {
            $this->average_cost = ($currentValue + $newValue) / $totalQuantity;
        }
    }

    public function checkAndCreateAlerts()
    {
        // Check for low stock
        if ($this->low_stock_alert && $this->isLowStock()) {
            if ($this->stock_quantity === 0) {
                InventoryAlert::createZeroStockAlert($this);
            } elseif ($this->isBelowMinimumLevel()) {
                InventoryAlert::createLowStockAlert($this);
            } elseif ($this->isAtReorderLevel()) {
                InventoryAlert::createReorderAlert($this);
            }
        }

        // Check for expiry alerts
        if ($this->expiry_alert && $this->track_expiry) {
            $expiringBatches = $this->inventoryBatches()
                ->expiringSoon($this->expiry_alert_days)
                ->whereDoesntHave('alerts', function($q) {
                    $q->where('type', 'expiry_warning')
                      ->where('status', 'active');
                })->get();

            foreach ($expiringBatches as $batch) {
                InventoryAlert::createExpiryAlert($batch, false);
            }

            $expiredBatches = $this->inventoryBatches()
                ->expired()
                ->whereDoesntHave('alerts', function($q) {
                    $q->where('type', 'expired')
                      ->where('status', 'active');
                })->get();

            foreach ($expiredBatches as $batch) {
                InventoryAlert::createExpiryAlert($batch, true);
            }
        }
    }

    public function getTotalBatchValue()
    {
        return $this->inventoryBatches()
                   ->active()
                   ->sum(\DB::raw('quantity_remaining * unit_cost'));
    }

    public function getOldestBatchDate()
    {
        return $this->inventoryBatches()
                   ->active()
                   ->min('received_date');
    }

    public function generateBarcode()
    {
        if (!$this->barcode) {
            // Generate a simple barcode based on ID and timestamp
            $this->barcode = 'PRD' . str_pad($this->id, 8, '0', STR_PAD_LEFT) . substr(time(), -4);
            $this->save();
        }
        return $this->barcode;
    }

    // Scope for filtering
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByBrand($query, $brand)
    {
        return $query->where('brand', $brand);
    }

    public function scopeLowStock($query, $threshold = 10)
    {
        return $query->where('stock_quantity', '<=', $threshold);
    }

    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->where('expiry_date', '<=', now()->addDays($days));
    }
} 