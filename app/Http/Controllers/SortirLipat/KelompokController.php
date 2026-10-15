<?php

namespace App\Http\Controllers\SortirLipat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PetugasModel;
use App\Models\KelompokModel;
use App\Models\SorlipModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KelompokController extends Controller
{
    public function index()
    {
        $data_kelompok = KelompokModel::with('pengawas_id')->get();
        return view('admin.sortir_lipat.index', compact('data_kelompok'));
    }
    public function create(): View
    {
        $pengawas = User::where('hak_pengawas', 1)
                    ->with('kecamatan')->get();
        return view('admin.sortir_lipat.create', compact('pengawas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_kelompok' => 'required|string|max:255',
            'pengawas' => 'required',
        ]);
        $existingKelompok = KelompokModel::where('nama_kelompok', $request->nama_kelompok)
                ->first();
        if ($existingKelompok) {
        return redirect()->route('kelompok.create')
        ->with('error', $request->nama_kelompok. ' sudah ada di Database!');
        }
        KelompokModel::create([
            'nama_kelompok' => $request->nama_kelompok,
            'pengawas' => $request->pengawas,
        ]);
        return redirect()->route('sorlip.index')->with('success', 'Kelompok '. $request->nama_kelompok. ' berhasil ditambahkan');
    }

    public function edit(KelompokModel $kelompok) : View
    {
        $pengawas = User::where('hak_pengawas', 1)
                    ->with('kecamatan')->get();
        return view('admin.sortir_lipat.edit', compact('kelompok', 'pengawas'));
    }
    public function show(KelompokModel $kelompok) : View
    {
        $pengawas = User::where('hak_pengawas', 1)
                        ->with('kecamatan')
                        ->get();
        $petugas = PetugasModel::where('kelompok', $kelompok->id_kelompok)->get();
        $total_box_disorlip = [];
        $total_surat_suara_disorlip = [];
        foreach ($petugas as $petugas_sorlip) {
            $total_box_disorlip[$petugas_sorlip->id_petugas] = SorlipModel::where('petugas', $petugas_sorlip->id_petugas)->count();
            $total_surat_suara_disorlip[$petugas_sorlip->id_petugas] = SorlipModel::where('petugas', $petugas_sorlip->id_petugas)
                ->sum('isi_setelah_disorlip');
        }
        return view('admin.sortir_lipat.show', compact('kelompok', 
                                                    'pengawas',
                                                    'petugas',
                                                    'total_box_disorlip',
                                                    'total_surat_suara_disorlip'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama_kelompok' => 'required',
            'pengawas' => 'required',
        ]);
        $kelompok = KelompokModel::find($id);
        if (!$kelompok) {
            return redirect()->route('sorlip.index')
                            ->with('error', 'Data tidak ditemukan');
        }

        $existingPengawas = KelompokModel::where('pengawas', $request->pengawas)->first();

        if ($existingPengawas) {
            return redirect()->route('kelompok.edit', $id)
                             ->with('error', 'Pengawas tersebut telah menjadi pengawas kelompok lain!');
        }

        $kelompok->nama_kelompok = $request->nama_kelompok;
        $kelompok->pengawas = $request->pengawas;
        $kelompok->save();
        return redirect()->route('sorlip.index')
                        ->with('success', 'Data berhasil diperbarui! ');
    }

    public function destroy(KelompokModel $kelompok) : RedirectResponse
    {
        $kelompok->delete();    
        return redirect()->route('sorlip.index')
                        ->with('success', 'Data berhasil dihapus!');
    }
}