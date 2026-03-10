<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Auditable
{
    /**
     * Boot the auditable trait
     */
    protected static function bootAuditable()
    {
        static::created(function ($model) {
            $model->auditCreated();
        });

        static::updated(function ($model) {
            $model->auditUpdated();
        });

        static::deleted(function ($model) {
            $model->auditDeleted();
        });
    }

    /**
     * Get all audit logs for this model
     */
    public function auditLogs(): MorphMany
    {
        return $this->morphMany(AuditLog::class, 'model', 'model_type', 'model_id');
    }

    /**
     * Log model creation
     */
    protected function auditCreated()
    {
        if ($this->shouldAudit('created')) {
            AuditLog::createLog(
                'created',
                $this,
                null,
                $this->getAuditableAttributes(),
                $this->getAuditDescription('created')
            );
        }
    }

    /**
     * Log model update
     */
    protected function auditUpdated()
    {
        if ($this->shouldAudit('updated') && $this->isDirty()) {
            $oldValues = [];
            $newValues = [];
            
            foreach ($this->getDirty() as $field => $newValue) {
                if (!in_array($field, $this->getAuditExclude())) {
                    $oldValues[$field] = $this->getOriginal($field);
                    $newValues[$field] = $newValue;
                }
            }

            if (!empty($oldValues)) {
                AuditLog::createLog(
                    'updated',
                    $this,
                    $oldValues,
                    $newValues,
                    $this->getAuditDescription('updated')
                );
            }
        }
    }

    /**
     * Log model deletion
     */
    protected function auditDeleted()
    {
        if ($this->shouldAudit('deleted')) {
            AuditLog::createLog(
                'deleted',
                $this,
                $this->getAuditableAttributes(),
                null,
                $this->getAuditDescription('deleted')
            );
        }
    }

    /**
     * Determine if the model should be audited for a specific action
     */
    protected function shouldAudit($action): bool
    {
        $auditEvents = $this->getAuditEvents();
        return in_array($action, $auditEvents);
    }

    /**
     * Get the events that should be audited
     */
    protected function getAuditEvents(): array
    {
        return $this->auditEvents ?? ['created', 'updated', 'deleted'];
    }

    /**
     * Get fields to exclude from auditing
     */
    protected function getAuditExclude(): array
    {
        return array_merge(
            $this->auditExclude ?? [],
            ['updated_at', 'created_at', 'remember_token']
        );
    }

    /**
     * Get auditable attributes
     */
    protected function getAuditableAttributes(): array
    {
        $attributes = $this->getAttributes();
        $exclude = $this->getAuditExclude();
        
        return array_diff_key($attributes, array_flip($exclude));
    }

    /**
     * Get audit description for an action
     */
    protected function getAuditDescription($action): string
    {
        $modelName = class_basename(get_class($this));
        $identifier = $this->getAuditIdentifier();
        
        switch ($action) {
            case 'created':
                return "{$modelName} '{$identifier}' was created";
            case 'updated':
                return "{$modelName} '{$identifier}' was updated";
            case 'deleted':
                return "{$modelName} '{$identifier}' was deleted";
            default:
                return "{$modelName} '{$identifier}' was {$action}";
        }
    }

    /**
     * Get identifier for the model in audit logs
     */
    protected function getAuditIdentifier(): string
    {
        // Try common identifier fields
        if (isset($this->name)) {
            return $this->name;
        }
        
        if (isset($this->title)) {
            return $this->title;
        }
        
        if (isset($this->email)) {
            return $this->email;
        }
        
        if (isset($this->sku)) {
            return $this->sku;
        }
        
        return "ID: {$this->id}";
    }

    /**
     * Manually create an audit log
     */
    public function audit($action, $description = null, $oldValues = null, $newValues = null)
    {
        return AuditLog::createLog(
            $action,
            $this,
            $oldValues,
            $newValues,
            $description ?: $this->getAuditDescription($action)
        );
    }
}
