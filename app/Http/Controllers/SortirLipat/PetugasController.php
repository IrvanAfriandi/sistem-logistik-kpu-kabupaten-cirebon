<?php

namespace App\Http\Controllers\SortirLipat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PetugasModel;
use App\Models\SorlipModel;
use App\Models\KelompokModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PetugasController extends Controller
{
    public function index(Request $request) : view
    {
        $petugas = PetugasModel::with('kelompok_sorlip')->get();
        return view('admin.sortir_lipat.petugas.index', compact('petugas'));
    }
    public function create() : view
    {
        $kelompok = KelompokModel::all();
        return view('admin.sortir_lipat.petugas.create', compact('kelompok'));
    }
     
    public function store(Request $request) : RedirectResponse
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'umur' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'nik' => 'required',
            'kelompok' => 'required',
            'foto' => 'required',
          ]);
          $petugas = new PetugasModel; 
          $petugas->nama = $request->nama;
          $petugas->jenis_kelamin = $request->jenis_kelamin;
          $petugas->umur = $request->umur;
          $petugas->alamat = $request->alamat;
          $petugas->telepon = $request->telepon;
          $petugas->nik = $request->nik;
          $petugas->kelompok = $request->kelompok;
          $petugas->foto = $request->foto;
          $petugas->save();   
        return redirect()->route('petugas.index')
                         ->with('success','petugas_sorlip has been created successfully.');
    }
       
    public function show($id_petugas) : View
    {
        $petugas = PetugasModel::findOrFail($id_petugas);
        $sorlip_data = SorlipModel::where('petugas', $id_petugas)
            ->with('box_id.jenis_surat')
            ->get();
        return view('admin.sortir_lipat.petugas.show', compact('petugas', 'sorlip_data'));
    }
    
    
    public function edit($id) : view
    {
        $petugas_sorlip = PetugasModel::findOrFail($id);
        return view('admin.sortir_lipat.petugas.edit',compact('petugas_sorlip'));
    }
     
    
    public function update(Request $request, $id_petugas) : RedirectResponse
    {
        $request->validate([
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'umur' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'nik' => 'required',
            'kelompok' => 'required',
            'foto' => 'required',
          ]);
          $petugas = PetugasModel::find($id_petugas); 
          // Check if petugas exists
          if (!$petugas) {
              return redirect()->route('petugas.index')
                              ->with('error', 'Petugas not found');
          }
          $petugas->nama= $request->nama;
          $petugas->jenis_kelamin= $request->jenis_kelamin;
          $petugas->umur= $request->umur;
          $petugas->alamat= $request->alamat;
          $petugas->telepon= $request->telepon;
          $petugas->nik= $request->nik;
          $petugas->kelompok= $request->kelompok;
          $petugas->foto= $request->foto;
          $petugas->save();
     
        return redirect()->route('petugas.index')
                         ->with('success','petugas_sorlip Has Been updated successfully');
    }
     
    public function destroy($id) : RedirectResponse
    {
        $petugas_sorlip = PetugasModel::findOrFail($id);
        $petugas_sorlip->delete();    
        return redirect()->route('petugas.index')
                        ->with('success','petugas_sorlip has been deleted successfully');
    }
}
