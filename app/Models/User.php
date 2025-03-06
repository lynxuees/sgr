<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the role associated with the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if the user has a specific role or multiple roles.
     */
    public function hasRole($roles): bool
    {
        return in_array($this->role->name, (array) $roles);
    }

    /**
     * Get the wastes generated by the user.
     */
    public function wastes()
    {
        return $this->hasMany(Waste::class);
    }

    /**
     * Get the collections assigned to the user (if they are a collector).
     */
    public function collections()
    {
        return $this->hasMany(Collection::class, 'collector_id');
    }

    /**
     * Get the reports created by the user.
     */
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
