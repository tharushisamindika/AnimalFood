<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesTarget extends Model
{
    use HasFactory;

    protected $fillable = [
        'target_date',
        'daily_target',
        'achieved_amount',
        'target_quantity',
        'achieved_quantity',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'target_date' => 'date',
        'daily_target' => 'decimal:2',
        'achieved_amount' => 'decimal:2',
        'achieved_quantity' => 'integer',
        'is_active' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForDate($query, $date)
    {
        return $query->where('target_date', $date);
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('target_date', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('target_date', now()->month)->whereYear('target_date', now()->year);
    }

    // Helper methods
    public function getProgressPercentage(): float
    {
        if ($this->daily_target <= 0) {
            return 0;
        }
        return min(100, ($this->achieved_amount / $this->daily_target) * 100);
    }

    public function getQuantityProgressPercentage(): float
    {
        if (!$this->target_quantity || $this->target_quantity <= 0) {
            return 0;
        }
        return min(100, ($this->achieved_quantity / $this->target_quantity) * 100);
    }

    public function isTargetMet(): bool
    {
        return $this->achieved_amount >= $this->daily_target;
    }

    public function isQuantityTargetMet(): bool
    {
        if (!$this->target_quantity) {
            return true;
        }
        return $this->achieved_quantity >= $this->target_quantity;
    }

    public function getRemainingAmount(): float
    {
        return max(0, $this->daily_target - $this->achieved_amount);
    }

    public function getRemainingQuantity(): int
    {
        if (!$this->target_quantity) {
            return 0;
        }
        return max(0, $this->target_quantity - $this->achieved_quantity);
    }

    public function updateAchievement(float $amount, int $quantity = 0): void
    {
        $this->increment('achieved_amount', $amount);
        if ($quantity > 0) {
            $this->increment('achieved_quantity', $quantity);
        }
    }

    // Static methods
    public static function getOrCreateForDate($date, $target = 0, $quantity = null): self
    {
        return static::firstOrCreate(
            ['target_date' => $date],
            [
                'daily_target' => $target,
                'target_quantity' => $quantity,
                'achieved_amount' => 0,
                'achieved_quantity' => 0,
                'is_active' => true,
            ]
        );
    }

    public static function getTodayTarget(): ?self
    {
        return static::forDate(today())->active()->first();
    }
}
