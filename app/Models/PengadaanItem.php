<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengadaanItem extends Model
{
    use HasFactory;

    protected $table = 'pengadaan_items';
    
    public function katalog()
    {
        return $this->belongsTo(Katalog::class);
    }
}
