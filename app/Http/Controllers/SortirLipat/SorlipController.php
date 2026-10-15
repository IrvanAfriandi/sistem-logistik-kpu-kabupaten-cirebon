<?php

namespace App\Http\Controllers\SortirLipat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PetugasModel;
use App\Models\KelompokModel;
use App\Models\SorlipModel;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SorlipController extends Controller
{
    public function index()
    {
        $data_kelompok = KelompokModel::with('pengawas_id')->withCount('petugas')->get();

        return view('admin.sortir_lipat.index', compact('data_kelompok'));
    }
    public function create(): View
    {
        return view('admin.perlengkapan.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_perlengkapan' => 'required|string|max:255',
            'jumlah_tersimpan' => 'required',
        ]);
        $existingPerlengkapan = SorlipModel::where('nama_perlengkapan', $request->nama_perlengkapan)
                ->first();
        if ($existingPerlengkapan) {
        return redirect()->route('perlengkapan.create')
        ->with('error', $request->nama_perlengkapan. ' sudah ada di Database!');
        }
        SorlipModel::create([
            'nama_perlengkapan' => $request->nama_perlengkapan,
            'jumlah_tersimpan' => $request->jumlah_tersimpan,
        ]);
        return redirect()->route('perlengkapan.index')->with('success', $request->nama_perlengkapan. ' berhasil ditambahkan');
    }

    public function edit(SorlipModel $perlengkapan) : View
    {
        return view('admin.perlengkapan.edit', compact('perlengkapan'));
    }
    
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama_perlengkapan' => 'required',
            'jumlah_tersimpan' => 'required',
        ]);
        $perlengkapan = SorlipModel::find($id);
        if (!$perlengkapan) {
            return redirect()->route('perlengkapan.index')
                            ->with('error', 'Data tidak ditemukan');
        }
        $perlengkapan->nama_perlengkapan = $request->nama_perlengkapan;
        $perlengkapan->jumlah_tersimpan = $request->jumlah_tersimpan;
        $perlengkapan->save();
        return redirect()->route('perlengkapan.index')
                        ->with('success', 'Data berhasil diperbarui! ');
    }

    public function destroy(SorlipModel $perlengkapan) : RedirectResponse
    {
        $perlengkapan->delete();    
        return redirect()->route('perlengkapan.index')
                        ->with('success', 'Data berhasil dihapus!');
    }
}