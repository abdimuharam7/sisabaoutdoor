<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Katalog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,numeric,string>
     */

    protected $fillable = [
        'nama',
        'harga',
        'stok',
        'foto',
        'deskripsi'
    ];

}
