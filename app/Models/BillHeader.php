<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillHeader extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'company_name',
        'company_logo',
        'company_address',
        'company_phone',
        'company_email',
        'company_website',
        'tax_number',
        'invoice_prefix',
        'footer_text',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Fields to exclude from audit logging
     */
    protected $auditExclude = [
        'updated_at',
        'created_at'
    ];

    /**
     * Get the active bill header
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }

    /**
     * Get identifier for audit logging
     */
    protected function getAuditIdentifier(): string
    {
        return $this->company_name ?? "Bill Header ID: {$this->id}";
    }

    /**
     * Get custom audit description for bill header changes
     */
    protected function getAuditDescription($action): string
    {
        $companyName = $this->company_name ?? 'Bill Header';
        
        switch ($action) {
            case 'created':
                return "Bill header settings for '{$companyName}' were created";
            case 'updated':
                return "Bill header settings for '{$companyName}' were updated";
            case 'deleted':
                return "Bill header settings for '{$companyName}' were deleted";
            default:
                return "Bill header settings for '{$companyName}' were {$action}";
        }
    }
}
