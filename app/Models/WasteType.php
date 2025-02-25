<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WasteType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function wastes()
    {
        return $this->hasMany(Waste::class);
    }
}

