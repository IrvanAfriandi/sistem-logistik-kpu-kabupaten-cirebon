@extends("layouts.layouts_ppk.dashboard")
@section("content")
</div>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
    <div class="page-heading">
        <h3>Pengawas Sortir & Lipat</h3>
    </div> 
<div class="page-content"> 
    <section class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-start">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h6 class="text-muted font-extrabold">Nama</h6>
                                    <h6 class="font-extrabold mb-0 text-shrink">Ahmad Sudrajat Ahmad Bustomi</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-start">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h6 class="text-muted font-extrabold">PPK Asal</h6>
                                    <h6 class="font-extrabold mb-0">Karangwareng</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-start">
                                    <div class="stats-icon green mb-2">
                                        <i class="iconly-boldAdd-User"></i>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h6 class="text-muted font-extrabold">Kelompok</h6>
                                    <h6 class="font-extrabold mb-0">9</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-start">
                                    <div class="stats-icon red mb-2">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h6 class="text-muted font-extrabold">Hari Ke</h6>
                                    <h6 class="font-extrabold mb-0">3</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive datatable-minimal">
                    <table class="table" >
                        <thead>
                            <tr>
                                <th>Nama Petugas</th>
                                <th>Kelompok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($petugas_sorlip as $petugas_sorlip)
                            <tr>
                                <td>{{ $petugas_sorlip->nama_petugas }}</td>
                                <td>{{ $petugas_sorlip->kelompok }}</td>
                                <td>{{ $petugas_sorlip->total_disorlip }}</td>
                                <td>
                                    @if($petugas_sorlip->total_disorlip === 'belum mulai')
                                    <form action="{{ route('ppk.mulaiProses') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_petugas" value="{{ $petugas_sorlip->id_petugas }}">
                                        <select name="id_box" class="form-control">
                                            @foreach($boxTertutup as $box)
                                            <option value="{{ $box->id_box }}">{{ $box->nomor_box }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-primary">Mulai Proses</button>
                                    </form>
                                    @elseif($petugas_sorlip->total_disorlip === 'dalam proses')
                                    <form action="{{ route('ppk.selesaiProses') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_petugas" value="{{ $petugas_sorlip->id_petugas }}">
                                        <input type="hidden" name="id_box" value="{{ $petugas_sorlip->id_box }}">
                                        <input type="number" name="jumlah_disorlip" placeholder="Jumlah disorlip" class="form-control" required>
                                        <input type="number" name="surat_rusak" placeholder="Surat rusak" class="form-control" required>
                                        <input type="text" name="kategori_rusak" placeholder="Kategori rusak" class="form-control">
                                        <button type="submit" class="btn btn-success">Selesaikan</button>
                                    </form>
                                    @else
                                    <button class="btn btn-secondary" disabled>Selesai</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    
                </div>
                <form action="{{ route('ppk.selesaikanHari') }}" method="POST">
                    @csrf
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success">Selesaikan Sorlip Hari Ini</button>
                    </div>
                </form>
            </div>
        </div>

    </section>
</div>
@endsection