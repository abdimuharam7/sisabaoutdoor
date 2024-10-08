<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;
    public function item()
    {
        return $this->hasMany(ItemPemesanan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
