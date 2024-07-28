<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }

    
    public function denda()
    {
        return $this->hasMany(Denda::class, 'pengembalian_id');
    }
}
