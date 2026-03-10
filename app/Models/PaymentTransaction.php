<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentTransaction extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'transaction_number',
        'customer_id',
        'order_id',
        'user_id',
        'type',
        'payment_method',
        'amount',
        'payment_date',
        'reference_number',
        'description',
        'payment_details',
        'status',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'payment_details' => 'array',
    ];

    /**
     * Generate the next transaction number
     */
    public static function generateTransactionNumber()
    {
        $lastTransaction = self::orderBy('id', 'desc')->first();
        $lastNumber = $lastTransaction ? (int) substr($lastTransaction->transaction_number, 4) : 0;
        $nextNumber = $lastNumber + 1;
        return 'TXN-' . str_pad($nextNumber, 8, '0', STR_PAD_LEFT);
    }

    /**
     * Relationships
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (!$transaction->transaction_number) {
                $transaction->transaction_number = self::generateTransactionNumber();
            }
        });

        static::created(function ($transaction) {
            // Update customer credit if applicable
            if ($transaction->type === 'payment' && $transaction->status === 'completed') {
                $customerCredit = CustomerCredit::where('customer_id', $transaction->customer_id)->first();
                if ($customerCredit) {
                    $customerCredit->updateBalance($transaction->amount, 'payment');
                }
            }
        });
    }

    /**
     * Helper methods
     */
    public function getFormattedTypeAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->type));
    }

    public function getFormattedPaymentMethodAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->payment_method));
    }

    public function getFormattedStatusAttribute()
    {
        return ucfirst($this->status);
    }

    /**
     * Scopes
     */
    public function scopeByCustomer($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('payment_date', [$startDate, $endDate]);
    }

    public function scopeByPaymentMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePayments($query)
    {
        return $query->where('type', 'payment');
    }

    public function scopeRefunds($query)
    {
        return $query->where('type', 'refund');
    }
}