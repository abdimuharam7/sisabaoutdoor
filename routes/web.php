<?php

use App\Http\Controllers\AturanController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('wilujeng');
})->name('wilujeng');

Route::get('/wilujeng/login', function () {
    return view('login');
});
Route::get('payment/check/{code}',[PemesananController::class,'paymentCheck'])->name('payment.check');


Route::get('/dashboard', function () {
    if(Auth::user()->role == 'admin'){
        return redirect()->route('admin.dashboard');
    }elseif(Auth::user()->role == 'pemilik'){
        return redirect()->route('pemilik.dashboard');
    }elseif(Auth::user()->role == 'logistik'){
        return redirect()->route('logistik.dashboard');
    }elseif(Auth::user()->role =='pelanggan'){
        return redirect()->route('pelanggan.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// route admin
Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/admin/dashboard',function(){
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::resource('admin/pelanggan',UserController::class);
    Route::resource('admin/katalog', KatalogController::class);
    Route::resource('admin/pembayaran', PembayaranController::class);
    Route::resource('admin/pembayaran/edit', PembayaranController::class);

});

// route pemilik
Route::middleware(['auth','role:pemilik'])->group(function () {
    Route::get('/pemilik/dashboard',function(){
        return view('pemilik.dashboard');
    })->name('pemilik.dashboard');
});

// route logistik
Route::middleware(['auth','role:logistik'])->group(function () {
    Route::get('/logistik/dashboard',function(){
        return view('logistik.dashboard');
    })->name('logistik.dashboard');
    Route::resource('logistik/pengembalian', KatalogController::class);
});

//route pelanggan
Route::middleware(['auth','role:pelanggan'])->group(function () {
    Route::get('/pelanggan/dashboard',function(){
        return view('pelanggan.dashboard');
    })->name('pelanggan.dashboard');
    Route::get('pelanggan/aturan', [PelangganController::class, 'aturan'])->name('aturan');
    Route::get('pelanggan/katalog', [PelangganController::class, 'katalog'])->name('katalog');
    Route::post('pelanggan/pemesanan',[PemesananController::class,'store'])->name('pemesanan.store');
    Route::resource('pelanggan/keranjang', CartController::class);
    Route::get('pelanggan/pesanan',[PemesananController::class,'userPesanan'])->name('user.pesanan');
    Route::get('pelanggan/checkout/{kode}',[PemesananController::class,'userCheckout'])->name('user.checkout');
    Route::post('pelanggan/payment/{pemesanan}',[PemesananController::class,'payment'])->name('user.payment');


   // Route::get('/pelanggan/aturan', [AturanController::class, 'index'])->name('pelanggan.aturan');
   // Route::get('/pelanggan/katalog', [KatalogController::class,'index'])->name('pelanggan.katalog');
});


Route::get('/aturan', [AturanController::class, 'index'])->name('aturan');





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

