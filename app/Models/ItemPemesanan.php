<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPemesanan extends Model
{
    use HasFactory;

    public function katalog()
    {
        return $this->belongsTo(Katalog::class);
    }
}
