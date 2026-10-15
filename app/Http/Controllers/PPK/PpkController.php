<?php

namespace App\Http\Controllers\PPK;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PetugasSorlipModel;
use App\Models\SuratSuaraModel;
use App\Models\SorlipDetailModel;
use Illuminate\View\View;

class PpkController extends Controller
{
    public function index()
    {
        return view('ppk.index');
    }
    public function index1(Request $request) : view
    {
        // Ambil semua data petugas
        $petugas_sorlip = PetugasSorlipModel::all();
    
        // Ambil semua box surat suara yang statusnya terkunci
        $boxTertutup = SuratSuaraModel::where('status_box', 'terkunci')->get();
    
        return view('sorlip_pengawas.index', compact('petugas_sorlip', 'boxTertutup'));
    }
    

    public function mulaiProses(Request $request)
    {
        $petugas_sorlip = PetugasSorlipModel::find($request->id_petugas);
        $box = SuratSuaraModel::find($request->id_box);

        if ($box && $petugas_sorlip) {
            $box->update(['status_box' => 'terbuka']);
            $petugas_sorlip->update(['status' => 'dalam proses']);
        }

        return redirect()->back()->with('success', 'Proses sorlip dimulai!');
    }

    public function selesaiProses(Request $request)
    {
        $petugas_sorlip = PetugasSorlipModel::find($request->id_petugas);
        $box = SuratSuaraModel::find($request->id_box);

        if ($box && $petugas_sorlip) {
            // Tambahkan detail sorlip
            SorlipDetailModel::create([
                'id_petugas' => $petugas_sorlip->id_petugas,
                'id_box' => $box->id_box,
                'jumlah_disorlip' => $request->jumlah_disorlip,
                'surat_rusak' => $request->surat_rusak,
                'kategori_rusak' => $request->kategori_rusak,
                'tanggal_sorlip' => now(),
            ]);

            $box->update(['status_box' => 'tersorlip']);
            $petugas_sorlip->update(['status' => 'selesai']);
        }

        return redirect()->back()->with('success', 'Proses sorlip selesai!');
    }

    public function selesaikanHari(Request $request)
    {
        // Simpan log harian untuk semua petugas
        return redirect()->back()->with('success', 'Data sorlip hari ini telah disimpan!');
    }
}
