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


Route::namespace('App\Http\Controllers\Admin')->group(function(){
    
    Route::name('admin.')->prefix('/admin')->group(function () {

        Route::middleware('guest:admin')->group(function () {
            Route::get('/','LoginController@showLoginForm')->name('login');
            Route::get('/login','LoginController@showLoginForm')->name('login');
            Route::post('/login','LoginController@login');
        });
        
        Route::middleware(['auth:admin'])->group(function () {
            Route::post('/logout','LoginController@logout')->name('logout');
            Route::get('/dashboard',function(){
                return view('admin.dashboard');
            })->name('dashboard');

            // Route::resource('/pelanggan', UserController::class);
            Route::resource('/pelanggan','UserController');
            Route::resource('/katalog', 'KatalogController');

            Route::get('/katalog/{id}/json', [KatalogController::class, 'json'])->name('katalog.json');

            Route::name('pemesanan.')->prefix('/pemesanan')->group(function () {
                Route::get('/', 'PemesananController@index')->name('index');
                Route::get('/create', 'PemesananController@create')->name('create');
                Route::post('/store', 'PemesananController@store')->name('store');
                Route::get('/{id}', 'PemesananController@show')->name('show');
                Route::get('/{id}/pdf', 'PemesananController@pdf')->name('pdf');
                Route::get('/{id}/edit', 'PemesananController@edit')->name('edit');
                Route::get('/{id}/json', 'PemesananController@json')->name('json');
                Route::post('/{id}/update', 'PemesananController@update')->name('update');
                Route::delete('/{id}/destroy', 'PemesananController@destroy')->name('destroy');
            });

            Route::name('pengembalian.')->prefix('/pengembalian')->group(function () {
                Route::get('/', 'PengembalianController@index')->name('index');
                Route::get('/create', 'PengembalianController@create')->name('create');
                Route::post('/store', 'PengembalianController@store')->name('store');
                Route::get('/{id}', 'PengembalianController@show')->name('show');
                Route::get('/{id}/pdf', 'PengembalianController@pdf')->name('pdf');
                Route::get('/{id}/edit', 'PengembalianController@edit')->name('edit');
                Route::post('/{id}/update', 'PengembalianController@update')->name('update');
                Route::delete('/{id}/destroy', 'PengembalianController@destroy')->name('destroy');
            });

            Route::name('pengadaan.')->prefix('/pengadaan')->group(function () {
                Route::get('/', 'PengadaanController@index')->name('index');
                Route::get('/create', 'PengadaanController@create')->name('create');
                Route::post('/store', 'PengadaanController@store')->name('store');
                Route::get('/{id}', 'PengadaanController@show')->name('show');
                Route::get('/{id}/edit', 'PengadaanController@edit')->name('edit');
                Route::post('/{id}/update', 'PengadaanController@update')->name('update');
                Route::delete('/{id}/destroy', 'PengadaanController@destroy')->name('destroy');
            });

            
            Route::get('/profile', 'ProfileController@edit')->name('profile.edit');
            Route::patch('/profile', 'ProfileController@update')->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });
    });

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

