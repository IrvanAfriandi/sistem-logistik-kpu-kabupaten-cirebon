<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\PerlengkapanModel;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PerlengkapanController extends Controller
{
    public function index(): View
    {
        $data = PerlengkapanModel::orderBy('id_perlengkapan', 'asc')->get();
        return view('admin.perlengkapan.index', compact('data'));
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
        $existingPerlengkapan = PerlengkapanModel::where('nama_perlengkapan', $request->nama_perlengkapan)
                ->first();
        if ($existingPerlengkapan) {
        return redirect()->route('perlengkapan.create')
        ->with('error', $request->nama_perlengkapan. ' sudah ada di Database!');
        }
        PerlengkapanModel::create([
            'nama_perlengkapan' => $request->nama_perlengkapan,
            'jumlah_tersimpan' => $request->jumlah_tersimpan,
        ]);
        return redirect()->route('perlengkapan.index')->with('success', $request->nama_perlengkapan. ' berhasil ditambahkan');
    }

    public function edit(PerlengkapanModel $perlengkapan) : View
    {
        return view('admin.perlengkapan.edit', compact('perlengkapan'));
    }
    
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama_perlengkapan' => 'required',
            'jumlah_tersimpan' => 'required',
        ]);
        $perlengkapan = PerlengkapanModel::find($id);
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

    public function destroy(PerlengkapanModel $perlengkapan) : RedirectResponse
    {
        $perlengkapan->delete();    
        return redirect()->route('perlengkapan.index')
                        ->with('success', 'Data berhasil dihapus!');
    }
}