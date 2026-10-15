<?php

namespace App\Http\Controllers\SortirLipat;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PengawasAddController extends Controller
{
    public function index()
    {
        $users = User::where('hak_pengawas', '0')->where('role', 'PPK')->with('kecamatan')->get();
        return view('admin.sortir_lipat.pengawas.create', compact('users'));
    }

    public function update($user)
    {
        $pengawas = User::find($user);
        $pengawas->hak_pengawas = 1;
        $pengawas->save();
        return redirect()->route('pengawas_add.index')->with('success', 'Pengawas berhasil ditambah!');
    }

}
