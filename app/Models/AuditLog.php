<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'action',
        'model_type',
        'model_id',
        'old_values',
        'new_values',
        'changed_fields',
        'user_id',
        'user_name',
        'ip_address',
        'user_agent',
        'url',
        'description',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'changed_fields' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who performed the action
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the auditable model
     */
    public function auditable(): MorphTo
    {
        return $this->morphTo('model');
    }

    /**
     * Scope to filter by action
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope to filter by model type
     */
    public function scopeByModel($query, $modelType)
    {
        return $query->where('model_type', $modelType);
    }

    /**
     * Scope to filter by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to filter by date range
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Get formatted action name
     */
    public function getFormattedActionAttribute()
    {
        return ucfirst($this->action);
    }

    /**
     * Get model name without namespace
     */
    public function getModelNameAttribute()
    {
        return class_basename($this->model_type);
    }

    /**
     * Get formatted changes
     */
    public function getFormattedChangesAttribute()
    {
        if (!$this->changed_fields) {
            return 'No specific changes recorded';
        }

        $changes = [];
        foreach ($this->changed_fields as $field) {
            $oldValue = $this->old_values[$field] ?? 'N/A';
            $newValue = $this->new_values[$field] ?? 'N/A';
            
            // Handle sensitive fields
            if (in_array($field, ['password', 'password_confirmation'])) {
                $oldValue = '***';
                $newValue = '***';
            }
            
            $changes[] = "{$field}: {$oldValue} → {$newValue}";
        }

        return implode(', ', $changes);
    }

    /**
     * Create an audit log entry
     */
    public static function createLog($action, $model, $oldValues = null, $newValues = null, $description = null)
    {
        $changedFields = [];
        
        if ($oldValues && $newValues) {
            $changedFields = array_keys(array_diff_assoc($newValues, $oldValues));
        }

        return self::create([
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->id ?? null,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'changed_fields' => $changedFields,
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name ?? 'System',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
            'description' => $description,
        ]);
    }
}