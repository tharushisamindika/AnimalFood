<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'supplier_id',
        'name',
        'email',
        'phone',
        'secondary_phone',
        'address',
        'contact_person',
        'tax_number',
        'status',
        'is_blacklisted',
        'notes'
    ];

    protected $casts = [
        'is_blacklisted' => 'boolean',
    ];

    /**
     * Generate the next supplier ID
     */
    public static function generateSupplierId()
    {
        $lastSupplier = self::orderBy('id', 'desc')->first();
        $lastNumber = $lastSupplier ? (int) substr($lastSupplier->supplier_id, 4) : 0;
        $nextNumber = $lastNumber + 1;
        return 'SUP-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function purchaseReturns()
    {
        return $this->hasMany(PurchaseReturn::class);
    }
} 