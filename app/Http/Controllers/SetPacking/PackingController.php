<?php

namespace App\Http\Controllers\SetPacking;

use App\Http\Controllers\Controller;
use App\Models\DataKecamatanModel;

class PackingController extends Controller
{
    public function index()
    {
        $kecamatan = DataKecamatanModel::whereHas('kebutuhanSuratSuara')
                                    ->orWhereHas('kebutuhanPerlengkapan')
                                    ->get();

        return view('admin.set_packing.index', compact('kecamatan'));
    }
    public function show($id)
    {
        $kecamatan = DataKecamatanModel::with(['kebutuhanSuratSuara', 'kebutuhanPerlengkapan'])->findOrFail($id);
        return view('admin.set_packing.show', compact('kecamatan'));
    }
}
