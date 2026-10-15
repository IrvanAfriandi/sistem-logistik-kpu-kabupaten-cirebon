<?php

namespace App\Http\Controllers\SortirLipat;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PengawasController extends Controller
{
    public function index()
    {
        $users = User::where('hak_pengawas', '1')->with('kecamatan')->get();
        return view('admin.sortir_lipat.pengawas.index', compact('users'));
    }
    public function show()
    {
        $users = User::where('hak_pengawas', '0')->where('role', 'PPK')->with('kecamatan')->get();
        return view('admin.sortir_lipat.pengawas.create', compact('users'));
    }
    public function tambah_pengawas(Request $request, User $user)
    {
        $request->validate([
            'hak_pengawas' => 'required|in:0,1', // Validasi hak_pengawas agar hanya 0 atau 1
        ]);
        $user->hak_pengawas = 1;
        $user->save();
        return redirect()->route('pengawas.index')->with('success', 'Hak pengawas berhasil diupdate!');
    }
    public function update($user)
    {
        $pengawas = User::find($user);
        $pengawas->hak_pengawas = 0;
        $pengawas->save();
        return redirect()->route('pengawas.index')->with('success', 'Pengawas berhasil dihapus!');
    }

}
