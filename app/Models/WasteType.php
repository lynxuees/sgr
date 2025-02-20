<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function wastes()
    {
        return $this->hasMany(Waste::class);
    }
}

