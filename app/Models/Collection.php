<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'waste_id',
        'collector_id',
        'disposal_id',
        'quantity',
        'unit',
        'type',
        'classification',
        'state',
        'origin',
        'frequency',
        'schedule',
        'status',
        'date',
        'location'
    ];

    public function waste()
    {
        return $this->belongsTo(Waste::class);
    }

    public function collector()
    {
        return $this->belongsTo(User::class, 'collector_id');
    }

    public function disposal()
    {
        return $this->belongsTo(Disposal::class);
    }

}
