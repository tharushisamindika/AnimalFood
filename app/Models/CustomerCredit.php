<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerCredit extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'customer_id',
        'credit_limit',
        'current_balance',
        'available_credit',
        'total_purchases',
        'total_payments',
        'last_payment_date',
        'credit_approval_date',
        'approved_by',
        'credit_status',
        'notes'
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'available_credit' => 'decimal:2',
        'total_purchases' => 'decimal:2',
        'total_payments' => 'decimal:2',
        'last_payment_date' => 'date',
        'credit_approval_date' => 'date',
    ];

    /**
     * Relationships
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Helper methods
     */
    public function updateBalance($amount, $type = 'purchase')
    {
        if ($type === 'purchase') {
            $this->increment('current_balance', $amount);
            $this->increment('total_purchases', $amount);
            $this->decrement('available_credit', $amount);
        } elseif ($type === 'payment') {
            $this->decrement('current_balance', $amount);
            $this->increment('total_payments', $amount);
            $this->increment('available_credit', $amount);
            $this->last_payment_date = now();
        }
        
        $this->save();
    }

    public function canPurchase($amount)
    {
        return $this->credit_status === 'active' && $this->available_credit >= $amount;
    }

    public function getUtilizationPercentageAttribute()
    {
        if ($this->credit_limit == 0) return 0;
        return round(($this->current_balance / $this->credit_limit) * 100, 2);
    }

    public function getIsOverlimitAttribute()
    {
        return $this->current_balance > $this->credit_limit;
    }

    public function getFormattedCreditStatusAttribute()
    {
        return ucfirst($this->credit_status);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('credit_status', 'active');
    }

    public function scopeOverlimit($query)
    {
        return $query->whereRaw('current_balance > credit_limit');
    }

    public function scopeNearLimit($query, $percentage = 90)
    {
        return $query->whereRaw('(current_balance / credit_limit) * 100 >= ?', [$percentage]);
    }
}