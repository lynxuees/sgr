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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(WasteType::class);
    }

    public function collections()
    {
        return $this->hasMany(Collection::class);
    }

    public function getEffectiveStatusAttribute()
    {
        return $this->deleted_at ? 'Deshabilitado' : $this->status;
    }

}
