<?php

namespace App\Http\Controllers\Distribusi;

use App\Http\Controllers\Controller;
use App\Models\DataKecamatanModel;
use Illuminate\Http\Request;

class DistribusiController extends Controller
{
    public function index()
    {
        $kecamatan = DataKecamatanModel::whereHas('kebutuhanSuratSuara')
                                    ->orWhereHas('kebutuhanPerlengkapan')
                                    ->get();

        return view('admin.distribusi.index', compact('kecamatan'));
    }
}
