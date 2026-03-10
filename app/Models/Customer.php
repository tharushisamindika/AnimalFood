<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'customer_id',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'postal_code',
        'status',
        'customer_type',
        'company_name',
        'contact_person',
        'tax_number',
        'notes'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($customer) {
            if (empty($customer->customer_id)) {
                $customer->customer_id = self::generateCustomerId();
            }
        });
    }

    public static function generateCustomerId()
    {
        $prefix = 'CUST';
        $year = date('Y');
        $lastCustomer = self::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
        
        if ($lastCustomer) {
            $lastNumber = intval(substr($lastCustomer->customer_id, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . $year . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function credit()
    {
        return $this->hasOne(CustomerCredit::class);
    }

    public function paymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    public function getHasCreditAttribute()
    {
        return $this->credit()->exists();
    }

    public function getAvailableCreditAttribute()
    {
        return $this->credit ? $this->credit->available_credit : 0;
    }

    public function getCurrentBalanceAttribute()
    {
        return $this->credit ? $this->credit->current_balance : 0;
    }
} 