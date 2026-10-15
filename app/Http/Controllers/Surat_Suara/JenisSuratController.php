<?php

namespace App\Http\Controllers\Surat_Suara;

use App\Http\Controllers\Controller;
use App\Models\JenisSuratModel;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JenisSuratController extends Controller
{
    public function index(): View
    {
        $data = JenisSuratModel::orderBy('id_jenis_surat_suara', 'asc')->get();
        return view('admin.surat_suara.jenis.index', compact('data'));
    }

    public function create(): View
    {
        return view('admin.surat_suara.jenis.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_jenis_surat_suara' => 'required|string|max:255',
        ]);
        $existingJenis = JenisSuratModel::where('nama_jenis_surat_suara', $request->nama_jenis_surat_suara)
                ->first();
        if ($existingJenis) {
        return redirect()->route('jenis_surat.create')
        ->with('error', $request->nama_jenis_surat_suara. ' sudah ada di Database!');
        }
        JenisSuratModel::create([
            'nama_jenis_surat_suara' => $request->nama_jenis_surat_suara,
        ]);
        return redirect()->route('jenis_surat.index')->with('success', 'Jenis Surat Suara '.  $request->nama_jenis_surat_suara. ' berhasil ditambahkan');
    }

    public function edit(JenisSuratModel $jenis_surat) : View
    {
        return view('admin.surat_suara.jenis.edit', compact('jenis_surat'));
    }
    
    public function update(Request $request, $id_jenis_surat_suara): RedirectResponse
    {
        $request->validate([
            'nama_jenis_surat_suara' => 'required',
        ]);
        $jenis = JenisSuratModel::find($id_jenis_surat_suara);
        if (!$jenis) {
            return redirect()->route('jenis_surat.index')
                            ->with('error', 'Data Jenis Surat Suara tidak ditemukan');
        }
        $old_name = $jenis->nama_jenis_surat_suara;
        $jenis->nama_jenis_surat_suara = $request->nama_jenis_surat_suara;
        $jenis->save();
        return redirect()->route('jenis_surat.index')
                        ->with('success', $old_name. ' berhasil diubah menjadi '. $request->nama_jenis_surat_suara,);
    }

    public function destroy(JenisSuratModel $jenis_surat) : RedirectResponse
    {
        $jenis_surat->delete();    
        return redirect()->route('jenis_surat.index')
                        ->with('success','Box '.$jenis_surat->nama_jenis_surat_suara.' berhasil dihapus!');
    }
}
