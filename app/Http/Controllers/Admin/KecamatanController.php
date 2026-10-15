<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataKecamatanModel;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KecamatanController extends Controller
{
    public function index(): View
    {
        $data_kecamatan = DataKecamatanModel::orderBy('id_kecamatan', 'asc')->get();
        return view('admin.kecamatan.index', compact('data_kecamatan'));
    }

    public function create(): View
    {
        return view('admin.kecamatan.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
        ]);
        $existingKecamatan = DataKecamatanModel::where('nama_kecamatan', $request->nama_kecamatan)
                ->first();
        if ($existingKecamatan) {
        return redirect()->route('data_kecamatan.create')
        ->with('error', $request->nama_kecamatan. ' sudah ada di Database!');
        }
        DataKecamatanModel::create([
            'nama_kecamatan' => $request->nama_kecamatan,
        ]);
        return redirect()->route('data_kecamatan.index')->with('success', 'Kecamatan '.  $request->nama_kecamatan. ' berhasil ditambahkan');
    }

    public function edit(DataKecamatanModel $data_kecamatan) : View
    {
        return view('admin.kecamatan.edit', compact('data_kecamatan'));
    }
    
    public function update(Request $request, $id_kecamatan): RedirectResponse
    {
        $request->validate([
            'nama_kecamatan' => 'required',
        ]);
        $data_kecamatan = DataKecamatanModel::find($id_kecamatan);
        if (!$data_kecamatan) {
            return redirect()->route('data_kecamatan.index')
                            ->with('error', 'Data kecamatan tidak ditemukan');
        }
        $existingKecamatan = DataKecamatanModel::where('nama_kecamatan', $request->nama_kecamatan)
                                            ->where('id_kecamatan', '!=', $id_kecamatan)
                                            ->first();
        if ($existingKecamatan) {
            return redirect()->route('data_kecamatan.edit', $id_kecamatan)
                            ->with('error', $request->nama_kecamatan. ' sudah ada di Database!');
        }
        $old_name = $data_kecamatan->nama_kecamatan;
        $data_kecamatan->nama_kecamatan = $request->nama_kecamatan;
        $data_kecamatan->save();
        return redirect()->route('data_kecamatan.index')
                        ->with('success', $old_name. ' berhasil diubah menjadi '. $request->nama_kecamatan,);
    }

    public function destroy(DataKecamatanModel $data_kecamatan): RedirectResponse
    {
        $kecamatan = $data_kecamatan->nama_kecamatan;
        $data_kecamatan->delete();
        return redirect()->route('data_kecamatan.index')->with('success',$kecamatan. ' berhasil dihapus dari Database!');
    }
}

