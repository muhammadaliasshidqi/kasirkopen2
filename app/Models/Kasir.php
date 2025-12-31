<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Kasir extends Authenticatable
{
    use HasFactory;

    protected $table = 'kasir';
    protected $primaryKey = 'id_kasir';

    protected $fillable = [
        'nama_kasir',
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is kasir
     */
    public function isKasir(): bool
    {
        return $this->role === 'kasir';
    }
}