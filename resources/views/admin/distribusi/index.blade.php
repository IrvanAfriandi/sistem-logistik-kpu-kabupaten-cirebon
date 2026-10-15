@extends("layouts.layouts_admin.set_packing.dashboard")
@section("content")
</div>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        @if ($message = Session::get('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: '{{ $message }}',
                    timer: 5000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end',
                    timerProgressBar: true,
                });
            </script>
        @endif
    <div class="page-heading">
        <h3>Set & Packing Keperluan Pemilu Kecamatan</h3>
        
    </div> 
<div class="page-content"> 
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Progres Set & Packing</h5>
                    </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-lg">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">No</th>
                                            <th style="width: 35%;">Nama Kecamatan</th>
                                            <th style="width: 35%; text-align: center;">Progres</th>
                                            <th style="width: 25%;"></th>         
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $kecamatan as $kecamatan)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            
                                            <td class="col-3">
                                                <div class="d-flex align-items-center">
                                                    <p class="font-bold ms-3 mb-0">{{ $kecamatan->nama_kecamatan}}</p>
                                                </div>
                                            </td>
                                            <td class="col-3">
                                                <div class="progress progress-primary">
                                                    <div class="progress-bar progress-label" role="progressbar" style="width: 35%" aria-valuenow="35"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('packing.show', $kecamatan->id_kecamatan) }}" class="btn btn-sm btn-info">
                                                    <i data-feather="info"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h4>Inventori Pemilu</h4>
                </div>
                <div class="card-content pb-4">
                    <div class="table-responsive">
                        <table class="table table-hover table-lg">
                            <thead>
                                <tr>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="col-auto">
                                        <p class=" mb-0">Surat Suara Gubernur</p>
                                        <p class="mb-0"><strong>1280</strong></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-auto">
                                        <p class=" mb-0">Surat Suara Bupati / Walikota</p>
                                        <p class="mb-0"><strong>7280</strong></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-auto">
                                        <p class=" mb-0">Tinta Pemilu</p>
                                        <p class="mb-0"><strong>206</strong></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div>
    </section>
</div>
@endsection