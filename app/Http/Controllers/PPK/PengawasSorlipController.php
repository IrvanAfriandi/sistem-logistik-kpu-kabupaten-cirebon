<?php

namespace App\Http\Controllers\PPK;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Models\PetugasModel;
use App\Models\JenisSuratModel;
use App\Models\SorlipModel;
use App\Models\BoxModel;
use App\Models\SuratRusakModel;
use App\Models\KategoriRusakModel;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PengawasSorlipController extends Controller
{
    public function index()
    {
        $data_petugas = PetugasModel::whereHas('kelompok_sorlip', function ($query) {
            $query->where('pengawas', auth()->user()->id);
        })->get();
        $total_box_disorlip = [];
        $total_surat_suara_disorlip = [];
        $status = [];
        foreach ($data_petugas as $petugas_sorlip) {
            $total_box_disorlip[$petugas_sorlip->id_petugas] = SorlipModel::where('petugas', $petugas_sorlip->id_petugas)->count();
            $total_surat_suara_disorlip[$petugas_sorlip->id_petugas] = SorlipModel::where('petugas', $petugas_sorlip->id_petugas)->sum('isi_setelah_disorlip');
            $status[$petugas_sorlip->id_petugas] = SorlipModel::where('petugas', $petugas_sorlip->id_petugas)
                    ->where(function ($query) {
                        $query->whereNull('isi_setelah_disorlip')
                            ->orWhere('isi_setelah_disorlip', 0);
                    })
                    ->orderBy('id_sorlip', 'desc')
                    ->first();
        }
        return view('ppk.sortir_lipat.index', compact('data_petugas', 'total_box_disorlip', 'total_surat_suara_disorlip', 'status'));
    }

    public function edit($id) : View
    {
        $info_petugas = PetugasModel::with(['kelompok_sorlip.pengawas_id'])
                                    ->where('id_petugas', $id)
                                    ->first();
        $jenisSurat = JenisSuratModel::all();
        return view('ppk.sortir_lipat.mulai', compact('info_petugas', 'jenisSurat'));
    }

    public function selesaikanPage($id_sorlip)
    {
        $sorlip = SorlipModel::with(['petugas_id.kelompok_sorlip', 'box_id.jenis_surat'])->findOrFail($id_sorlip);
        $surat_rusak = SuratRusakModel::where('id_sorlip', $sorlip->id_sorlip)->get();
        $surat_rusak_kategori = KategoriRusakModel::all();
        return view('ppk.sortir_lipat.selesai', compact('sorlip', 'surat_rusak','surat_rusak_kategori'));
    }

    public function show($id_petugas) : View
    {
        $petugas = PetugasModel::findOrFail($id_petugas);
        $sorlip_data = SorlipModel::where('petugas', $id_petugas)
            ->with('box_id.jenis_surat')
            ->get();
        $total_box_disorlip[$id_petugas] = SorlipModel::where('petugas', $id_petugas)->count();
        $total_surat_suara_disorlip[$id_petugas] = SorlipModel::where('petugas', $id_petugas)->sum('isi_setelah_disorlip');
        return view('ppk.sortir_lipat.show', compact('petugas', 'sorlip_data', 'total_box_disorlip', 'total_surat_suara_disorlip'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_petugas' => 'required',
            'id_pengawas' => 'required',
            'nama_pengawas' => 'required',
            'nomor_box' => 'required',
        ]);
        SorlipModel::create([
            'petugas' => $request->id_petugas,
            'dibuka_oleh' => $request->nama_pengawas,
            'id_box' => $request->nomor_box,
            'waktu_dibuka' => now(),
        ]);
        $box = BoxModel::find($request->nomor_box);
        $box->status_box = 1;
        $box->waktu_terakhir_diedit = now();
        $box->terakhir_diedit_oleh = $request->nama_pengawas;
        $box->save();

        return redirect()->route('sorlip_pengawas.index')->with('success', 'Kelompok '. $request->nama_kelompok. ' berhasil ditambahkan');
    }
    
    public function update(Request $request, $id): RedirectResponse
    {
        $sorlip = SorlipModel::find($id);
        if (!$sorlip) {
            return redirect()->route('sorlip.index')
                            ->with('error', 'Data tidak ditemukan');
        }
        $sorlip->isi_setelah_disorlip = $request->isi_setelah_disorlip;
        $sorlip->waktu_selesai = now();
        $sorlip->diselesaikan_oleh = $request->nama_pengawas;
        $sorlip->save();
        foreach ($request->jumlah_rusak as $kategori_rusak_id => $jumlah_rusak) {
            $surat_rusak_1 = new SuratRusakModel;
            $surat_rusak_1->id_sorlip = $sorlip->id_sorlip;
            $surat_rusak_1->jumlah_rusak = $jumlah_rusak;
            $surat_rusak_1->kategori_rusak = $kategori_rusak_id;
            $surat_rusak_1->save();
        }
        $box = BoxModel::find($request->nomor_box);
        $box->status_box = 2;
        $box->waktu_terakhir_diedit = now();
        $box->terakhir_diedit_oleh = $request->nama_pengawas;
        $box->save();
        return redirect()->route('sorlip_pengawas.index')
                        ->with('success', 'Data berhasil diperbarui! ');
    }

    public function getBoxesByJenis($jenis_id)
    {
        $boxes = BoxModel::where('jenis', $jenis_id)->get();
        return response()->json($boxes);
    }
    

    public function getIsiBox($box_id)
    {
        $box = BoxModel::find($box_id);
        return response()->json(['isi_awal' => $box ? $box->isi_awal : '']);
    }

    public function generatePDF($id)
    {
        // Ambil data petugas
        $petugas = PetugasModel::findOrFail($id);

        // Ambil data sorlip
        $sorlip_data = SorlipModel::where('id_petugas', $id)->get();

        // Hitung total box dan total surat suara
        $total_box_disorlip = $sorlip_data->count();
        $total_surat_suara_disorlip = $sorlip_data->sum('isi_setelah_disorlip');

        // Render PDF dengan view khusus
        $pdf = PDF::loadView('pdf.sorlip', compact('petugas', 'sorlip_data', 'total_box_disorlip', 'total_surat_suara_disorlip'));

        // Download file PDF
        return $pdf->download('laporan_sorlip_' . $petugas->nama . '.pdf');
    }
}