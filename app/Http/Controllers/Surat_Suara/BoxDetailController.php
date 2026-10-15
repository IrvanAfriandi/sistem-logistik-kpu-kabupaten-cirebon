<?php

namespace App\Http\Controllers\Surat_Suara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BoxModel;
use App\Models\JenisSuratModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BoxDetailController extends Controller
{
    public function index(Request $request)
    {
        $data = BoxModel::with('jenis_surat')->get();
        return view('admin.surat_suara.box.index', compact('data'));
    }
}
