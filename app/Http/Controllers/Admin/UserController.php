<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::paginate(3);
        $search = $request->input('search');
        $pelanggan = user::when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('nomor_wa', 'like', "%{$search}%");
        })->paginate(3);

        $pelanggan = User::where('role', 'pelanggan')->get();
        return view("admin.pelanggan.index", compact('pelanggan'));
    }
    public function create()
    {
        return view('admin.pelanggan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' =>['required', 'string', 'in:Laki-Laki,Perempuan'],
            'nomor_wa'=>['required','string', 'max:15'],
            'alamat_ktp'=>['required','string', 'max:255'],
            'alamat_domisili'=>['required','string', 'max:255'],
            'tgl_lahir'=>['required','date'],
            'ktp'=>['required',],
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
        if ($request->hasFile('ktp')) {
            $file = $request->file('ktp');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ktp'), $fileName);
            $user->ktp = $fileName;
        }
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success','Berhasil');
    }
    public function edit($id)
    {
        $pelanggan = User::find($id);
        return view('admin.pelanggan.edit',compact('pelanggan'));
    }
    public function show($id)
    {
        $data = User::find($id);
        return view('admin.pelanggan.show',compact('data'));
    }
    public function update(Request $request, $id){
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' =>['required', 'string', 'in:Laki-Laki,Perempuan'],
            'nomor_wa'=>['required','string', 'max:15'],
            'alamat_ktp'=>['required','string', 'max:255'],
            'alamat_domisili'=>['required','string', 'max:255'],
            'tgl_lahir'=>['required','date'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $user = User::find($id);
        $user->nama = $request->nama;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->nomor_wa = $request->nomor_wa;
        $user->alamat_ktp = $request->alamat_ktp;
        $user->alamat_domisili = $request->alamat_domisili;
        $user->tgl_lahir = $request->tgl_lahir;
        $user->email = $request->email;
        if ($request->hasFile('ktp')) {
            $file = $request->file('ktp');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ktp'), $fileName);
            $user->ktp = $fileName;
        }
        if($request->password && $request->password !== null){
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('admin.pelanggan.index')->with('success','Berhasil');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('admin.pelanggan.index')->with('success','Berhasil');
    }
}
