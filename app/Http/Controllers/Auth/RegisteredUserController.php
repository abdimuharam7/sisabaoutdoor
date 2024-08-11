<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Storage;
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' =>['required', 'string', 'in:Laki-Laki,Perempuan'],
            'nomor_wa'=>['required','string', 'max:15'],
            'alamat_ktp'=>['required','string', 'max:255'],
            'alamat_domisili'=>['required','string', 'max:255'],
            'tgl_lahir'=>['required','date'],
            'ktp' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string','min:8','confirmed', Rules\Password::defaults()],
        ]);

        $user = new User();
        $user->nama = $request->nama;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->nomor_wa = $request->nomor_wa;
        $user->alamat_ktp = $request->alamat_ktp;
        $user->alamat_domisili = $request->alamat_domisili;
        $user->tgl_lahir = $request->tgl_lahir;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if ($request->hasFile('ktp')) {
            $file = $request->file('ktp');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ktp'), $fileName);
            $user->ktp = $fileName;
        }
        $user->save();
        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
