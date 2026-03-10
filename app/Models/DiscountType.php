<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DiscountType extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'name',
        'code',
        'description',
        'type',
        'value',
        'minimum_amount',
        'maximum_discount',
        'valid_from',
        'valid_until',
        'is_active',
        'is_automatic',
        'applicable_products',
        'applicable_categories',
        'usage_limit',
        'terms_conditions'
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'minimum_amount' => 'decimal:2',
        'maximum_discount' => 'decimal:2',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
        'is_automatic' => 'boolean',
        'applicable_products' => 'array',
        'applicable_categories' => 'array',
    ];

    /**
     * Helper methods
     */
    public function calculateDiscount($orderAmount, $items = [])
    {
        // Check if discount is valid
        if (!$this->isValid($orderAmount)) {
            return 0;
        }

        // Check if specific products/categories apply
        if (!$this->isApplicableToItems($items)) {
            return 0;
        }

        $discountAmount = 0;

        if ($this->type === 'percentage') {
            $discountAmount = ($orderAmount * $this->value) / 100;
        } else {
            $discountAmount = $this->value;
        }

        // Apply maximum discount limit
        if ($this->maximum_discount && $discountAmount > $this->maximum_discount) {
            $discountAmount = $this->maximum_discount;
        }

        return round($discountAmount, 2);
    }

    public function isValid($orderAmount = 0)
    {
        // Check if active
        if (!$this->is_active) {
            return false;
        }

        // Check minimum amount
        if ($orderAmount < $this->minimum_amount) {
            return false;
        }

        // Check date validity
        $now = Carbon::now();
        
        if ($this->valid_from && $now->lt($this->valid_from)) {
            return false;
        }

        if ($this->valid_until && $now->gt($this->valid_until)) {
            return false;
        }

        return true;
    }

    public function isApplicableToItems($items = [])
    {
        // If no specific products/categories, applicable to all
        if (empty($this->applicable_products) && empty($this->applicable_categories)) {
            return true;
        }

        foreach ($items as $item) {
            // Check product-specific discounts
            if (!empty($this->applicable_products) && 
                in_array($item['product_id'] ?? $item->product_id, $this->applicable_products)) {
                return true;
            }

            // Check category-specific discounts
            if (!empty($this->applicable_categories) && 
                in_array($item['category_id'] ?? $item->product->category_id, $this->applicable_categories)) {
                return true;
            }
        }

        return false;
    }

    public function getFormattedTypeAttribute()
    {
        return $this->type === 'percentage' ? 'Percentage' : 'Fixed Amount';
    }

    public function getFormattedValueAttribute()
    {
        return $this->type === 'percentage' 
            ? $this->value . '%' 
            : '$' . number_format($this->value, 2);
    }

    public function getIsExpiredAttribute()
    {
        return $this->valid_until && Carbon::now()->gt($this->valid_until);
    }

    public function getIsUpcomingAttribute()
    {
        return $this->valid_from && Carbon::now()->lt($this->valid_from);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeValid($query)
    {
        $now = Carbon::now();
        return $query->where('is_active', true)
                    ->where(function($q) use ($now) {
                        $q->whereNull('valid_from')
                          ->orWhere('valid_from', '<=', $now);
                    })
                    ->where(function($q) use ($now) {
                        $q->whereNull('valid_until')
                          ->orWhere('valid_until', '>=', $now);
                    });
    }

    public function scopeAutomatic($query)
    {
        return $query->where('is_automatic', true);
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }
}