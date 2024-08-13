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
class DashboardController extends Controller
{

    public function index(){


        $data = Collect([
            'pelanggan' => User::where('role', 'pelanggan')->latest()->get()->count(),
            'pemesanan' => Pemesanan::latest()->get()->count(),
        ]);

        return view('admin.dashboard', compact('data'));
    }


}