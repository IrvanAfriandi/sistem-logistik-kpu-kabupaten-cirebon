<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DataKecamatanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserppkController extends Controller
{
    public function index()
    {
        // Mengambil semua user dengan role 'ppk' dan melakukan eager load relasi kecamatan
        $users = User::where('role', 'PPK')->with('kecamatan')->get();
        
        return view('admin.users.users_ppk.index', compact('users'));
    }


    public function create()
    {
        $kecamatanList = DataKecamatanModel::all();
        return view('admin.users.users_ppk.create', compact('kecamatanList'));    
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required',
            'id_kecamatan' => 'required|exists:data_kecamatan,id_kecamatan'
        ]);
    
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'id_kecamatan' => $request->id_kecamatan,
        ]);
    
        return redirect()->route('users_ppk.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit(User $users_ppk)
    {
        // Mengambil semua kecamatan
        $kecamatanList = DataKecamatanModel::all();
        
        // Mengirim data users_ppk dan kecamatanList ke view
        return view('admin.users.users_ppk.edit', compact('users_ppk', 'kecamatanList'));
    }


    public function update(Request $request, User $users_ppk)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $users_ppk->id,
            'password' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk foto
            'divisi' => 'nullable',
            'jabatan' => 'nullable',
            'jenis_kelamin' => 'nullable',
            'umur' => 'nullable',
            'alamat' => 'nullable',
            'no_telepon' => 'nullable',
            'id_kecamatan' => 'required|exists:data_kecamatan,id_kecamatan'
        ]);

        if ($request->hasFile('foto')) {
            if ($users_ppk->foto) {
                $oldImagePath = public_path('images') . '/' . $users_ppk->foto;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
    
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); 
            $image->move(public_path('images'), $imageName);
            $users_ppk->foto = $imageName; 
        }
    
        $users_ppk->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $users_ppk->password,
            'divisi' => $request->divisi,
            'jabatan' => $request->jabatan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'umur' => $request->umur,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'id_kecamatan' => $request->id_kecamatan,
            'foto' => $users_ppk->foto,
        ]);

        return redirect()->route('users_ppk.index')->with('success', 'Pengguna berhasil diperbarui.');
    }


    public function destroy(User $users_ppk)
    {
        $users_ppk->delete();
        return redirect()->route('users_ppk.index')->with('success', 'User berhasil dihapus.');
    }
}
