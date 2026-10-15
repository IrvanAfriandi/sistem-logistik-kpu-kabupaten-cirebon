<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserAdminController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'Admin')->get();
        return view('admin.users.users_admin.index', compact('users'));
    }
    public function create()
    {
        return view('admin.users.users_admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'role' => 'required',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        return redirect()->route('users_admin.index')->with('success', $request->email. ' berhasil ditambahkan.');
    }

    public function edit(User $users_admin) : View
    {
        return view('admin.users.users_admin.edit', compact('users_admin'));
    }    

    public function update(Request $request, User $users_admin)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $users_admin->id,
            'password' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk foto
            'divisi' => 'nullable',
            'jabatan' => 'nullable',
            'jenis_kelamin' => 'nullable',
            'umur' => 'nullable',
            'alamat' => 'nullable',
            'no_telepon' => 'nullable',
        ]);

        if ($request->hasFile('foto')) {
            if ($users_admin->foto) {
                $oldImagePath = public_path('images') . '/' . $users_admin->foto;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
    
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); 
            $image->move(public_path('images'), $imageName);
            $users_admin->foto = $imageName; 
        }
    
        $users_admin->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $users_admin->password,
            'divisi' => $request->divisi,
            'jabatan' => $request->jabatan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'umur' => $request->umur,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'foto' => $users_admin->foto,
        ]);
    
        return redirect()->route('users_admin.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $users_admin)
    {
        $users_admin->delete();
        return redirect()->route('users_admin.index')->with('success', 'User berhasil dihapus.');
    }
}

