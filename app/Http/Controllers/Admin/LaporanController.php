<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItemPemesanan;
use App\Models\Katalog;
use App\Models\Pemesanan;
use App\Models\User;
use Duitku\Api;
use Duitku\Config;
use Exception;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use PDF;

class LaporanController extends Controller
{

    public function pemesanan(){

        return view('admin.laporan.pemesanan');
    }

    
    public function pengembalian(){


        return view('admin.laporan.pengembalian');
    }


    public function pembelian(){


        return view('admin.laporan.pembelian');
    }

    public function keterlambatan(){


        return view('admin.laporan.keterlambatan');
    }
}