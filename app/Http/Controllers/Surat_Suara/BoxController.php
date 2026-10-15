<?php

namespace App\Http\Controllers\Surat_Suara;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BoxModel;
use App\Models\DataKecamatanModel;
use App\Models\JenisSuratModel;
use App\Models\KategoriRusakModel;
use App\Models\PackingBoxDetailModel;
use App\Models\PackingBoxModel;
use App\Models\PackingModel;
use App\Models\PetugasModel;
use App\Models\SorlipModel;
use App\Models\SuratRusakModel;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Carbon;


class BoxController extends Controller
{
    public function index(Request $request)
    {
        $data = BoxModel::with('jenis_surat')->get();
        return view('admin.surat_suara.box.index', compact('data'));
    }

    public function create() : view
    {
        $jenis = JenisSuratModel::all(); 
        $nama = auth()->user()->nama;
        return view('admin.surat_suara.box.create', compact('jenis', 'nama'));  
    }
    
    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'nomor_box' => 'required',
            'jenis' => 'required',
            'isi_awal' => 'required',
            'ditambahkan_oleh' => 'required',

        ]);

        $exists = BoxModel::where('nomor_box', $request->nomor_box)
                                ->where('jenis', $request->jenis)
                                ->exists();

        if ($exists) {
            return redirect()->route('box.create')
                            ->with('error', 'Data tersebut telah ada di Database!');
        }

        $box = new BoxModel; 
        $box->nomor_box = $request->nomor_box;
        $box->jenis = $request->jenis;
        $box->isi_awal = $request->isi_awal;
        $box->ditambahkan_oleh = $request->ditambahkan_oleh;
        $box->waktu_ditambahkan = Carbon::now();
        $box->save(); 

        return redirect()->route('box.index')
                         ->with('success','Box '.$request->nomor_box.' Berhasil ditambahkan!');
    }
       
    public function show(BoxModel $box) : view
    {
        $jenis = JenisSuratModel::all();
        $box = BoxModel::with('jenis_surat')->find($box->id_box);
        $nama = auth()->user()->nama;
        $pengawas = User::where('role', 'Admin')
                    ->orWhere('hak_pengawas', 1)
                    ->orderByRaw("role = 'Admin' DESC")
                    ->with('kecamatan')->get();
        $ppk = User::where('role', 'Admin')
                    ->orWhere('role', 'PPK')
                    ->orderByRaw("role = 'Admin' DESC")
                    ->with('kecamatan')->get();
        $sorlip = SorlipModel::where('id_box', $box->id_box)->first() ?? new SorlipModel();
        $petugas_list = PetugasModel::with('kelompok_sorlip')->get();
        $surat_rusak = SuratRusakModel::where('id_sorlip', $sorlip->id_sorlip)->get();
        $surat_rusak_kategori = KategoriRusakModel::all();
        $packing = PackingBoxModel::where('id_box', $box->id_box)->first() ?? new PackingBoxModel();
        $packing_detail = PackingBoxDetailModel::where('id_packing_box', $packing->id_packing_box)->get();
        $kecamatanList = DataKecamatanModel::all();

        return view('admin.surat_suara.box.show', compact( 'box',
                                                        'jenis', 
                                                        'nama', 
                                                        'pengawas', 
                                                        'sorlip', 
                                                        'petugas_list', 
                                                        'surat_rusak', 
                                                        'surat_rusak_kategori', 
                                                        'ppk',
                                                        'packing',
                                                        'packing_detail',
                                                        'kecamatanList'
                                                    ));
    } 
      
    
    public function edit(BoxModel $box) : view
    {
        $jenis = JenisSuratModel::all();
        $nama = auth()->user()->nama;
        $pengawas = User::where('role', 'Admin')
                    ->orWhere('hak_pengawas', 1)
                    ->orderByRaw("role = 'Admin' DESC")
                    ->with('kecamatan')->get();
        $ppk = User::where('role', 'Admin')
                    ->orWhere('role', 'PPK')
                    ->orderByRaw("role = 'Admin' DESC")
                    ->with('kecamatan')->get();
        $sorlip = SorlipModel::where('id_box', $box->id_box)->first() ?? new SorlipModel();
        $petugas_list = PetugasModel::with('kelompok_sorlip')->get();
        $surat_rusak = SuratRusakModel::where('id_sorlip', $sorlip->id_sorlip)->get();
        $surat_rusak_kategori = KategoriRusakModel::all();
        $packing = PackingBoxModel::where('id_box', $box->id_box)->first() ?? new PackingBoxModel();
        $packing_detail = PackingBoxDetailModel::where('id_packing_box', $packing->id_packing_box)->get();
        $kecamatanList = DataKecamatanModel::all();

        return view('admin.surat_suara.box.edit', compact( 'box', 
                                                        'jenis', 
                                                        'nama', 
                                                        'pengawas', 
                                                        'sorlip', 
                                                        'petugas_list', 
                                                        'surat_rusak', 
                                                        'surat_rusak_kategori', 
                                                        'ppk',
                                                        'packing',
                                                        'packing_detail',
                                                        'kecamatanList'
                                                    ));
    }
    
    
    public function update(Request $request, $id_box) : RedirectResponse
    {
        $request->validate([
            'nomor_box' => 'required',
            'jenis' => 'required',
            'isi_awal' => 'required',
            'status_box' => 'required',
        ]);
    
        $exists = BoxModel::where('nomor_box', $request->nomor_box)
            ->where('jenis', $request->jenis)
            ->where('id_box', '!=', $id_box)
            ->exists();
    
        if ($exists) {
            return redirect()->route('box.edit', $id_box)
                ->with('error', 'Data tersebut telah ada di Database!');
        }
    
        $waktu_dibuka = $this->adjustTime($request->waktu_dibuka);
        $waktu_selesai = $this->adjustTime($request->waktu_selesai);
        $waktu_mulai_packing = $this->adjustTime($request->waktu_mulai_packing);
        $waktu_selesai_packing = $this->adjustTime($request->waktu_selesai_packing);
    
        $box = BoxModel::find($id_box);
        $sorlip = SorlipModel::where('id_box', $id_box)->first();
    
        $box->nomor_box = $request->nomor_box;
        $box->jenis = $request->jenis;
        $box->isi_awal = $request->isi_awal;
        $box->status_box = $request->status_box;
        $box->waktu_terakhir_diedit = now();
        $box->terakhir_diedit_oleh = auth()->user()->nama;
        $box->save();
    
        if ($request->status_box == 0) {
        } elseif ($request->status_box == 1) {
            if ($sorlip) {
                $sorlip->waktu_dibuka = $waktu_dibuka;
                $sorlip->dibuka_oleh = $request->dibuka_oleh;
                $sorlip->save();
            } else {
                $sorlip_1 = new SorlipModel;
                $sorlip_1->id_box = $id_box;
                $sorlip_1->waktu_dibuka = $waktu_dibuka;
                $sorlip_1->dibuka_oleh = $request->dibuka_oleh;
                $sorlip_1->save();
            }
        } elseif ($request->status_box == 2) {
            if ($sorlip) {
                $sorlip->waktu_dibuka = $waktu_dibuka;
                $sorlip->dibuka_oleh = $request->dibuka_oleh;
                $sorlip->petugas = $request->petugas;
                $sorlip->isi_setelah_disorlip = $request->isi_setelah_disorlip;
                $sorlip->waktu_selesai = $waktu_selesai;
                $sorlip->diselesaikan_oleh = $request->diselesaikan_oleh;
                $sorlip->save();
                foreach ($request->jumlah_rusak as $kategori_rusak_id => $jumlah_rusak) {
                    $surat_rusak = SuratRusakModel::where('id_sorlip', $sorlip->id_sorlip)
                        ->where('kategori_rusak', $kategori_rusak_id)
                        ->first();
                    if ($surat_rusak) {
                        $surat_rusak->jumlah_rusak = $jumlah_rusak;
                        $surat_rusak->kategori_rusak = $kategori_rusak_id;
                        $surat_rusak->save();
                    } else {
                        $surat_rusak_1 = new SuratRusakModel;
                        $surat_rusak_1->id_sorlip = $sorlip->id_sorlip;
                        $surat_rusak_1->jumlah_rusak = $jumlah_rusak;
                        $surat_rusak_1->kategori_rusak = $kategori_rusak_id;
                        $surat_rusak_1->save();
                    }
                }
            } else {
                $sorlip_1 = new SorlipModel;
                $sorlip_1->id_box = $id_box;
                $sorlip_1->waktu_dibuka = $waktu_dibuka;
                $sorlip_1->dibuka_oleh = $request->dibuka_oleh;
                $sorlip_1->petugas = $request->petugas;
                $sorlip_1->isi_setelah_disorlip = $request->isi_setelah_disorlip;
                $sorlip_1->waktu_selesai = $waktu_selesai;
                $sorlip_1->diselesaikan_oleh = $request->diselesaikan_oleh;
                $sorlip_1->save();
                foreach ($request->jumlah_rusak as $kategori_rusak_id => $jumlah_rusak) {
                    $surat_rusak_1 = new SuratRusakModel;
                    $surat_rusak_1->id_sorlip = $sorlip_1->id_sorlip;
                    $surat_rusak_1->jumlah_rusak = $jumlah_rusak;
                    $surat_rusak_1->kategori_rusak = $kategori_rusak_id;
                    $surat_rusak_1->save();
                }
            }
        } elseif ($request->status_box == 3) {
            if ($sorlip) {
                $sorlip->waktu_dibuka = $waktu_dibuka;
                $sorlip->dibuka_oleh = $request->dibuka_oleh;
                $sorlip->petugas = $request->petugas;
                $sorlip->isi_setelah_disorlip = $request->isi_setelah_disorlip;
                $sorlip->waktu_selesai = $waktu_selesai;
                $sorlip->diselesaikan_oleh = $request->diselesaikan_oleh;
                $sorlip->save();
                foreach ($request->jumlah_rusak as $kategori_rusak_id => $jumlah_rusak) {
                    $surat_rusak = SuratRusakModel::where('id_sorlip', $sorlip->id_sorlip)
                        ->where('kategori_rusak', $kategori_rusak_id)
                        ->first();
                    if ($surat_rusak) {
                        $surat_rusak->jumlah_rusak = $jumlah_rusak;
                        $surat_rusak->kategori_rusak = $kategori_rusak_id;
                        $surat_rusak->save();
                        $packing = PackingBoxModel::where('id_box', $id_box)->first();
                        if ($packing) {
                            $packing->mulai_packing_oleh = $request->mulai_packing_oleh;
                            $packing->waktu_mulai_packing = $waktu_mulai_packing;
                            $packing->save();
                        } else {
                            $packing_1 = new PackingBoxModel;
                            $packing_1->id_box = $id_box;
                            $packing_1->mulai_packing_oleh = $request->mulai_packing_oleh;
                            $packing_1->waktu_mulai_packing = $waktu_mulai_packing;
                            $packing_1->save();
                        }
                    } else {
                        $surat_rusak_1 = new SuratRusakModel;
                        $surat_rusak_1->id_sorlip = $sorlip->id_sorlip;
                        $surat_rusak_1->jumlah_rusak = $jumlah_rusak;
                        $surat_rusak_1->kategori_rusak = $kategori_rusak_id;
                        $surat_rusak_1->save();
                        $packing = PackingBoxModel::where('id_box', $id_box)->first();
                        if ($packing) {
                            $packing->mulai_packing_oleh = $request->mulai_packing_oleh;
                            $packing->waktu_mulai_packing = $waktu_mulai_packing;
                            $packing->save();
                        } else {
                            $packing_1 = new PackingBoxModel;
                            $packing_1->id_box = $id_box;
                            $packing_1->mulai_packing_oleh = $request->mulai_packing_oleh;
                            $packing_1->waktu_mulai_packing = $waktu_mulai_packing;
                            $packing_1->save();
                        }
                    }
                }
            } else {
                $sorlip_1 = new SorlipModel;
                $sorlip_1->id_box = $id_box;
                $sorlip_1->waktu_dibuka = $waktu_dibuka;
                $sorlip_1->dibuka_oleh = $request->dibuka_oleh;
                $sorlip_1->petugas = $request->petugas;
                $sorlip_1->isi_setelah_disorlip = $request->isi_setelah_disorlip;
                $sorlip_1->waktu_selesai = $waktu_selesai;
                $sorlip_1->diselesaikan_oleh = $request->diselesaikan_oleh;
                $sorlip_1->save();
                foreach ($request->jumlah_rusak as $kategori_rusak_id => $jumlah_rusak) {
                    $surat_rusak_1 = new SuratRusakModel;
                    $surat_rusak_1->id_sorlip = $sorlip_1->id_sorlip;
                    $surat_rusak_1->jumlah_rusak = $jumlah_rusak;
                    $surat_rusak_1->kategori_rusak = $kategori_rusak_id;
                    $surat_rusak_1->save();
                }
                $packing_1 = new PackingBoxModel;
                $packing_1->id_box = $id_box;
                $packing_1->mulai_packing_oleh = $request->mulai_packing_oleh;
                $packing_1->waktu_mulai_packing = $waktu_mulai_packing;
                $packing_1->save();
            }
        } elseif ($request->status_box == 4) {
            if ($sorlip) {
                $sorlip->waktu_dibuka = $waktu_dibuka;
                $sorlip->dibuka_oleh = $request->dibuka_oleh;
                $sorlip->petugas = $request->petugas;
                $sorlip->isi_setelah_disorlip = $request->isi_setelah_disorlip;
                $sorlip->waktu_selesai = $waktu_selesai;
                $sorlip->diselesaikan_oleh = $request->diselesaikan_oleh;
                $sorlip->save();
                foreach ($request->jumlah_rusak as $kategori_rusak_id => $jumlah_rusak) {
                    $surat_rusak = SuratRusakModel::where('id_sorlip', $sorlip->id_sorlip)
                        ->where('kategori_rusak', $kategori_rusak_id)
                        ->first();
                    if ($surat_rusak) {
                        $surat_rusak->jumlah_rusak = $jumlah_rusak;
                        $surat_rusak->kategori_rusak = $kategori_rusak_id;
                        $surat_rusak->save();
                        $packing = PackingBoxModel::where('id_box', $id_box)->first();
                        if ($packing) {
                            $packing->mulai_packing_oleh = $request->mulai_packing_oleh;
                            $packing->waktu_mulai_packing = $waktu_mulai_packing;
                            $packing->selesai_packing_oleh = $request->selesai_packing_oleh;
                            $packing->waktu_selesai_packing = $waktu_selesai_packing;
                            $packing->save();

                            if ($request->has('kecamatan') && count($request->kecamatan) > 0) {
                                foreach ($request->kecamatan as $key => $kecamatan_id) {
                                    $packingBoxDetail = PackingBoxDetailModel::where('id_packing_box', $packing->id_packing_box)
                                        ->where('kecamatan', $kecamatan_id)
                                        ->first();
                                    if ($packingBoxDetail) {
                                        $packingBoxDetail->kecamatan = $kecamatan_id;
                                        $packingBoxDetail->isi_dipakai = $request->input('isi_dipakai')[$key];
                                        $packingBoxDetail->sisa_isi_box = $request->input('sisa_isi_box')[$key];
                                        $packingBoxDetail->save();
                                    } else {
                                        $packingBoxDetail_1 = new PackingBoxDetailModel();
                                        $packingBoxDetail_1->id_packing_box = $packing->id_packing_box;
                                        $packingBoxDetail_1->kecamatan = $kecamatan_id;
                                        $packingBoxDetail_1->isi_dipakai = $request->input('isi_dipakai')[$key];
                                        $packingBoxDetail_1->sisa_isi_box = $request->input('sisa_isi_box')[$key];
                                        $packingBoxDetail_1->save();
                                    }
                                }
                            }
                        } else {
                            $packing_1 = new PackingBoxModel;
                            $packing_1->id_box = $id_box;
                            $packing_1->mulai_packing_oleh = $request->mulai_packing_oleh;
                            $packing_1->waktu_mulai_packing = $waktu_mulai_packing;
                            $packing_1->selesai_packing_oleh = $request->selesai_packing_oleh;
                            $packing_1->waktu_selesai_packing = $waktu_selesai_packing;
                            $packing_1->save();

                            if ($request->has('kecamatan') && count($request->kecamatan) > 0) {
                                foreach ($request->kecamatan as $key => $kecamatan_id) {
                                    $packingBoxDetail = PackingBoxDetailModel::where('id_packing_box', $packing->id_packing_box)
                                        ->where('kecamatan', $kecamatan_id)
                                        ->first();
                                    if ($packingBoxDetail) {
                                        $packingBoxDetail->kecamatan = $kecamatan_id;
                                        $packingBoxDetail->isi_dipakai = $request->input('isi_dipakai')[$key];
                                        $packingBoxDetail->sisa_isi_box = $request->input('sisa_isi_box')[$key];
                                        $packingBoxDetail->save();
                                    } else {
                                        $packingBoxDetail_1 = new PackingBoxDetailModel();
                                        $packingBoxDetail_1->id_packing_box = $packing->id_packing_box;
                                        $packingBoxDetail_1->kecamatan = $kecamatan_id;
                                        $packingBoxDetail_1->isi_dipakai = $request->input('isi_dipakai')[$key];
                                        $packingBoxDetail_1->sisa_isi_box = $request->input('sisa_isi_box')[$key];
                                        $packingBoxDetail_1->save();
                                    }
                                }
                            }
                        }
                    } else {
                        $surat_rusak_1 = new SuratRusakModel;
                        $surat_rusak_1->id_sorlip = $sorlip->id_sorlip;
                        $surat_rusak_1->jumlah_rusak = $jumlah_rusak;
                        $surat_rusak_1->kategori_rusak = $kategori_rusak_id;
                        $surat_rusak_1->save();
                        $packing = PackingBoxModel::where('id_box', $id_box)->first();
                        if ($packing) {
                            $packing->mulai_packing_oleh = $request->mulai_packing_oleh;
                            $packing->waktu_mulai_packing = $waktu_mulai_packing;
                            $packing->selesai_packing_oleh = $request->selesai_packing_oleh;
                            $packing->waktu_selesai_packing = $waktu_selesai_packing;
                            $packing->save();
                        } else {
                            $packing_1 = new PackingBoxModel;
                            $packing_1->id_box = $id_box;
                            $packing_1->mulai_packing_oleh = $request->mulai_packing_oleh;
                            $packing_1->waktu_mulai_packing = $waktu_mulai_packing;
                            $packing_1->selesai_packing_oleh = $request->selesai_packing_oleh;
                            $packing_1->waktu_selesai_packing = $waktu_selesai_packing;
                            $packing_1->save();

                            if ($request->has('kecamatan') && count($request->kecamatan) > 0) {
                                foreach ($request->kecamatan as $key => $kecamatan_id) {
                                    $packingBoxDetail = PackingBoxDetailModel::where('id_packing_box', $packing->id_packing_box)
                                        ->where('kecamatan', $kecamatan_id)
                                        ->first();
                                    if ($packingBoxDetail) {
                                        $packingBoxDetail->kecamatan = $kecamatan_id;
                                        $packingBoxDetail->isi_dipakai = $request->input('isi_dipakai')[$key];
                                        $packingBoxDetail->sisa_isi_box = $request->input('sisa_isi_box')[$key];
                                        $packingBoxDetail->save();
                                    } else {
                                        $packingBoxDetail_1 = new PackingBoxDetailModel();
                                        $packingBoxDetail_1->id_packing_box = $packing->id_packing_box;
                                        $packingBoxDetail_1->kecamatan = $kecamatan_id;
                                        $packingBoxDetail_1->isi_dipakai = $request->input('isi_dipakai')[$key];
                                        $packingBoxDetail_1->sisa_isi_box = $request->input('sisa_isi_box')[$key];
                                        $packingBoxDetail_1->save();
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                $sorlip_1 = new SorlipModel;
                $sorlip_1->id_box = $id_box;
                $sorlip_1->waktu_dibuka = $waktu_dibuka;
                $sorlip_1->dibuka_oleh = $request->dibuka_oleh;
                $sorlip_1->petugas = $request->petugas;
                $sorlip_1->isi_setelah_disorlip = $request->isi_setelah_disorlip;
                $sorlip_1->waktu_selesai = $waktu_selesai;
                $sorlip_1->diselesaikan_oleh = $request->diselesaikan_oleh;
                $sorlip_1->save();
                foreach ($request->jumlah_rusak as $kategori_rusak_id => $jumlah_rusak) {
                    $surat_rusak_1 = new SuratRusakModel;
                    $surat_rusak_1->id_sorlip = $sorlip_1->id_sorlip;
                    $surat_rusak_1->jumlah_rusak = $jumlah_rusak;
                    $surat_rusak_1->kategori_rusak = $kategori_rusak_id;
                    $surat_rusak_1->save();
                }
                $packing_1 = new PackingBoxModel;
                $packing_1->id_box = $id_box;
                $packing_1->mulai_packing_oleh = $request->mulai_packing_oleh;
                $packing_1->waktu_mulai_packing = $waktu_mulai_packing;
                $packing_1->selesai_packing_oleh = $request->selesai_packing_oleh;
                $packing_1->waktu_selesai_packing = $waktu_selesai_packing;
                $packing_1->save();

                foreach ($request->kecamatan as $key => $kecamatan_id) {
                    $packingBoxDetail_1 = new PackingBoxDetailModel();
                    $packingBoxDetail_1->id_packing_box = $packing_1->id_packing_box;
                    $packingBoxDetail_1->kecamatan = $kecamatan_id;
                    $packingBoxDetail_1->isi_dipakai = $request->input('isi_dipakai')[$key];
                    $packingBoxDetail_1->sisa_isi_box = $request->input('sisa_isi_box')[$key];
                    $packingBoxDetail_1->save();
                }
            }
        }

        return redirect()->route('box.index')
            ->with('success', 'Box ' . $box->nomor_box . ' Telah berhasil Diupdate!');
    }

    private function adjustTime($time)
    {
        $sesuaikan = Carbon::parse($time);
        if ($sesuaikan->second == 0) {
            $angka_random = str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);
            return $sesuaikan->format('Y-m-d H:i:') . $angka_random;
        } else {
            return $sesuaikan->format('Y-m-d H:i:s');
        }
    }
    
    public function destroy(BoxModel $box) : RedirectResponse
    {
        $box->delete();    
        return redirect()->route('box.index')
                        ->with('success','Box '.$box->nomor_box.' berhasil dihapus!');
    }
}
     
