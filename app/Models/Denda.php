<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    use HasFactory;

    
    public function katalog()
    {
        return $this->belongsTo(Katalog::class);
    }
    
    public function pesan_item()
    {
        return $this->belongsTo(ItemPemesanan::class, 'pesan_item_id');
    }
}
