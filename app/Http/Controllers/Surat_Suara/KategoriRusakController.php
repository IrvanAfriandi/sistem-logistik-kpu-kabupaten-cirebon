<?php

namespace App\Http\Controllers\Surat_Suara;

use App\Http\Controllers\Controller;
use App\Models\KategoriRusakModel;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KategoriRusakController extends Controller
{
    public function index(): View
    {
        $data = KategoriRusakModel::orderBy('id_kategori_rusak', 'asc')->get();
        return view('admin.surat_suara.kategori_rusak.index', compact('data'));
    }

    public function create(): View
    {
        return view('admin.surat_suara.kategori_rusak.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_kerusakan' => 'required|string|max:255',
        ]);
        $existingKategori = KategoriRusakModel::where('nama_kerusakan', $request->nama_kerusakan)
                ->first();
        if ($existingKategori) {
        return redirect()->route('kategori_rusak.create')
        ->with('error', $request->nama_kerusakan. ' sudah ada di Database!');
        }
        KategoriRusakModel::create([
            'nama_kerusakan' => $request->nama_kerusakan,
        ]);
        return redirect()->route('kategori_rusak.index')->with('success', $request->nama_kerusakan. ' berhasil ditambahkan');
    }

    public function edit(KategoriRusakModel $kategori_rusak) : View
    {
        return view('admin.surat_suara.kategori_rusak.edit', compact('kategori_rusak'));
    }
    
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama_kerusakan' => 'required',
        ]);
        $kategori_rusak = KategoriRusakModel::find($id);
        if (!$kategori_rusak) {
            return redirect()->route('kategori_rusak.index')
                            ->with('error', 'Data tidak ditemukan');
        }
        $old_name = $kategori_rusak->nama_kerusakan;
        $kategori_rusak->nama_kerusakan = $request->nama_kerusakan;
        $kategori_rusak->save();
        return redirect()->route('kategori_rusak.index')
                        ->with('success', $old_name. ' berhasil diubah menjadi '. $request->nama_kerusakan,);
    }

    public function destroy(KategoriRusakModel $kategori_rusak) : RedirectResponse
    {
        $kategori_rusak->delete();    
        return redirect()->route('kategori_rusak.index')
                        ->with('success', $kategori_rusak->nama_kerusakan . ' berhasil dihapus!');
    }
}
