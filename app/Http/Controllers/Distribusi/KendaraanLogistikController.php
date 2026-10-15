<?php

namespace App\Http\Controllers\Distribusi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index()
    {
        return view('admin.distribusi.kendaraan.index');
    }
}
