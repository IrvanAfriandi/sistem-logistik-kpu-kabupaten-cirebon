<?php
namespace App\Http\Controllers;
namespace App\Models;
use Illuminate\Support\Facades\Route;

// Authentication
use App\Http\Controllers\Auth\LoginController;

// Admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\UserPPKController;

// PPK
use App\Http\Controllers\PPK\PpkController;

// Manajemen Data
use App\Http\Controllers\Admin\KecamatanController;

// Inventory
use App\Http\Controllers\Inventory\PerlengkapanController;

// Surat Suara
use App\Http\Controllers\Surat_Suara\BoxController;
use App\Http\Controllers\Surat_Suara\JenisSuratController;
use App\Http\Controllers\Surat_Suara\KategoriRusakController;

// Sortir & Lipat
use App\Http\Controllers\SortirLipat\SorlipController;
use App\Http\Controllers\SortirLipat\PengawasController;
use App\Http\Controllers\SortirLipat\PengawasAddController;
use App\Http\Controllers\SortirLipat\PetugasController;
use App\Http\Controllers\SortirLipat\KelompokController;

// Set & Packing
use App\Http\Controllers\SetPacking\PackingController;
use App\Http\Controllers\SetPacking\KebutuhanKecamatanController;

// Distribusi Logistik
use App\Http\Controllers\Distribusi\DistribusiController;
use App\Http\Controllers\Distribusi\DriverController;
use App\Http\Controllers\Distribusi\KendaraanController;

// PPK
use App\Http\Controllers\PPK\PengawasSorlipController;

// Halaman Pertama
Route::get('/', [LoginController::class, 'index'])->name('login');

// Authentifikasi
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin
Route::middleware(['auth'])->group(function () {
    Route::middleware(['is_admin'])->group(function () {
        Route::resource('admin', AdminController::class);
        Route::resource('users_admin', UserAdminController::class);
        Route::resource('users_ppk', UserPPKController::class);
        Route::resource('perlengkapan', PerlengkapanController::class);
    });
});

// PPK
Route::middleware(['auth'])->group(function () {
    Route::middleware(['is_ppk'])->group(function () {
        Route::resource('ppk', PpkController::class);
    });
});

// Manajemen Data
Route::resource('data_kecamatan', KecamatanController::class);

// Surat Suara
Route::resource('surat_suara', BoxController::class);
Route::resource('box', BoxController::class);
Route::resource('jenis_surat', JenisSuratController::class);
Route::resource('kategori_rusak', KategoriRusakController::class);

//Sortir & Lipat
Route::resource('sorlip', SorlipController::class);
Route::resource('petugas', PetugasController::class);
Route::resource('pengawas', PengawasController::class);
Route::resource('pengawas_add', PengawasAddController::class);
Route::resource('kelompok', KelompokController::class);

// Set & Packing
Route::resource('packing', PackingController::class);
Route::resource('kebutuhan_kecamatan', PackingController::class);

// Distribusi Logistik
Route::resource('distribusi', DistribusiController::class);
Route::resource('driver', DriverController::class);
Route::resource('kendaraan', KendaraanController::class);

// Pengawas
Route::resource('pengawas', PengawasController::class);
Route::resource('sorlip_pengawas', PengawasSorlipController::class);
Route::get('/sorlip-pengawas/{id_sorlip}/selesaikan', [PengawasSorlipController::class, 'selesaikanPage'])->name('sorlip_pengawas.selesaikan');

// Route tambahan untuk AJAX
Route::get('/get-boxes/{jenis_id}', function($jenis_id) {
    return response()->json(
        BoxModel::where('jenis', $jenis_id)
                ->where(function ($query) {
                    $query->whereNull('status_box') // Mencari yang NULL
                          ->orWhere('status_box', 0); // Mencari yang 0
                })
                ->get()
    );    
});

Route::get('/get-box-detail/{box_id}', function($box_id) {
    return response()->json(BoxModel::find($box_id));
});

// PDF
Route::get('/sorlip/pdf/{id}', [SorlipController::class, 'generatePDF'])->name('sorlip_pengawas.pdf');


