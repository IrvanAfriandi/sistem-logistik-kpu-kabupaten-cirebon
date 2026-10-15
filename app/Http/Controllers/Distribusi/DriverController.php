<?php

namespace App\Http\Controllers\Distribusi;

use App\Http\Controllers\Controller;
use App\Models\DriverModel;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DriverController extends Controller
{
    public function index(): View
    {
        $data = DriverModel::orderBy('id_driver', 'asc')->get();
        return view('admin.distribusi.driver.index', compact('data'));
    }

    public function create(): View
    {
        return view('admin.distribusi.driver.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_driver' => 'required',
            'jenis_kelamin' => 'required',
            'umur' => 'required',
            'no_telepon' => 'required',
            'alamat_driver' => 'required',
            'foto' => 'required',
        ]);
        $image = $request->file('foto');
        $imageName = time() . '.' . $image->getClientOriginalExtension(); 
        $image->move(public_path('images'), $imageName);

        DriverModel::create([
            'nama_driver' => $request->nama_driver,
            'jenis_kelamin' => $request->jenis_kelamin,
            'umur' => $request->umur,
            'no_telepon' => $request->no_telepon,
            'alamat_driver' => $request->alamat_driver,
            'foto' => $imageName,
        ]);
        return redirect()->route('driver.index')->with('success', $request->nama_driver. ' berhasil ditambahkan');
    }

    public function edit(DriverModel $driver) : View
    {
        return view('admin.distribusi.driver.edit', compact('driver'));
    }
    
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama_driver' => 'required',
            'jenis_kelamin' => 'required',
            'umur' => 'required',
            'no_telepon' => 'required',
            'alamat_driver' => 'required',
            'foto' => 'required',
        ]);

        if ($request->hasFile('foto')) {
            if ($id->foto) {
                $oldImagePath = public_path('images') . '/' . $id->foto;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
    
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); 
            $image->move(public_path('images'), $imageName);
            $id->foto = $imageName; 
        }

        $driver = DriverModel::find($id);
        if (!$driver) {
            return redirect()->route('driver.index')
                            ->with('error', 'Data tidak ditemukan');
        }
        $driver->nama_driver = $request->nama_driver;
        $driver->jenis_kelamin = $request->jenis_kelamin;
        $driver->umur = $request->umur;
        $driver->no_telepon = $request->no_telepon;
        $driver->alamat_driver = $request->alamat_driver;
        $driver->foto = $id->foto;
        $driver->save();
        return redirect()->route('driver.index')
                        ->with('success', 'Data berhasil diperbarui! ');
    }

    public function destroy(DriverModel $driver) : RedirectResponse
    {
        $driver->delete();    
        return redirect()->route('driver.index')
                        ->with('success', 'Data berhasil dihapus!');
    }
}
