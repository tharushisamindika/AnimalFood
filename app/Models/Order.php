<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'invoice_number',
        'customer_id',
        'user_id',
        'total_amount',
        'tax_amount',
        'discount_amount',
        'discount_type_id',
        'discount_code',
        'discount_type',
        'discount_percentage',
        'final_amount',
        'paid_amount',
        'due_amount',
        'due_date',
        'is_credit_sale',
        'credit_used',
        'status',
        'payment_status',
        'payment_method',
        'payment_breakdown',
        'invoice_date',
        'rounding_adjustment',
        'notes'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_amount' => 'decimal:2',
        'credit_used' => 'decimal:2',
        'rounding_adjustment' => 'decimal:2',
        'due_date' => 'date',
        'invoice_date' => 'datetime',
        'is_credit_sale' => 'boolean',
        'payment_breakdown' => 'array',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function discountType()
    {
        return $this->belongsTo(DiscountType::class);
    }

    public function paymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    // Helper methods
    public function getFormattedPaymentMethodAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->payment_method));
    }

    public function getIsOverdueAttribute()
    {
        return $this->due_date && $this->due_date->isPast() && $this->due_amount > 0;
    }

    public function getIsFullyPaidAttribute()
    {
        return $this->due_amount <= 0;
    }

    public function generateInvoiceNumber()
    {
        if (!$this->invoice_number) {
            $billHeader = \App\Models\BillHeader::getActive();
            $prefix = $billHeader->invoice_prefix ?? 'INV';
            $lastInvoice = self::whereNotNull('invoice_number')->orderBy('id', 'desc')->first();
            $lastNumber = $lastInvoice ? (int) substr($lastInvoice->invoice_number, strlen($prefix) + 1) : 0;
            $nextNumber = $lastNumber + 1;
            $this->invoice_number = $prefix . '-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
            $this->invoice_date = now();
            $this->save();
        }
        return $this->invoice_number;
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            if (!$order->order_number) {
                $lastOrder = static::whereYear('created_at', date('Y'))->latest()->first();
                $lastNumber = $lastOrder ? (int) substr($lastOrder->order_number, -6) : 0;
                $order->order_number = 'ORD-' . date('Y') . '-' . str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
            }
        });
    }
} 