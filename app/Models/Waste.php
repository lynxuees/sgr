<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Waste extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'type_id',
        'description',
        'quantity',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Get the user associated with this waste.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the type of waste.
     */
    public function wasteType()
    {
        return $this->belongsTo(WasteType::class, 'type_id');
    }

    /**
     * Get the collections related to this waste.
     */
    public function collections()
    {
        return $this->hasMany(Collection::class);
    }

    /**
     * Get the effective status of the waste, considering soft deletes.
     */
    public function getEffectiveStatusAttribute(): string
    {
        return $this->trashed() ? 'Deshabilitado' : $this->status;
    }

    /**
     * Scope to filter wastes by status.
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get wastes created this month.
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month);
    }

    /**
     * Get the total waste quantity processed.
     */
    public static function totalProcessed(): int
    {
        return static::where('status', 'Procesado')->sum('quantity');
    }

    /**
     * Get the total waste quantity generated this month.
     */
    public static function totalGeneratedThisMonth(): int
    {
        return static::whereMonth('created_at', now()->month)->sum('quantity');
    }
}
