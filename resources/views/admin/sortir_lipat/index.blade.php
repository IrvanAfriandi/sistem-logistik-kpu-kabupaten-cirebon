@extends("layouts.layouts_admin.sortir_lipat.dashboard")
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
        <h3>Sortir & Lipat Surat Suara</h3>
        
    </div> 
<div class="page-content"> 
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Petugas</h6>
                                    <h6 class="font-extrabold mb-0">11</h6>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card"> 
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Pengawas</h6>
                                    <h6 class="font-extrabold mb-0">18</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon green mb-2">
                                        <i class="iconly-boldAdd-User"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Box Telah Disorlip</h6>
                                    <h6 class="font-extrabold mb-0">80</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon red mb-2">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Box Belum Disorlip</h6>
                                    <h6 class="font-extrabold mb-0">112</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Kelompok Sortir & Lipat</h5>
                        <a href="{{ route('kelompok.create') }}" class="btn icon icon-left btn-success">
                            <i data-feather="plus"></i>
                        </a>
                    </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-lg">
                                    <thead>
                                        <tr>
                                            <th>Kelompok</th>
                                            <th>Pengawas</th>
                                            <th>Anggota</th>
                                            <th style="width: 150px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($data_kelompok as $kelompok)
                                        <tr>
                                            <td class="col-3">
                                                <div class="d-flex align-items-center">
                                                    <p class="font-bold ms-3 mb-0">{{ $kelompok->nama_kelompok }}</p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                <p class="mb-0">{{ $kelompok->pengawas_id ? $kelompok->pengawas_id->nama ?? 'Belum Diatur' : 'Belum Diatur' }}</p>
                                            </td>
                                            <td class="col-3">
                                                <div class="d-flex align-items-center">
                                                    <p class="font-bold ms-3 mb-0"> {{ $kelompok->petugas_count ?? 0 }}</p>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('kelompok.edit', $kelompok->id_kelompok) }}" class="btn btn-sm btn-warning"><i data-feather="edit"></i> </a>
                                                <a href="{{ route('kelompok.show', $kelompok->id_kelompok) }}" class="btn btn-sm btn-info"><i data-feather="info"></i> </a>
                                                <form action="{{ route('kelompok.destroy', $kelompok->id_kelompok) }}" method="POST" style="display:inline;" id="deleteForm-{{ $kelompok->id_kelompok }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $kelompok->id_kelompok }}', '{{ $kelompok->nama_kelompok }}')"><i data-feather="trash"></i> </button>
                                                </form>
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
                    <h4>Total Surat Suara Disorlip</h4>
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
                                        <p class=" mb-0">Gubernur</p>
                                        <p class="mb-0"><strong>1280</strong></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-auto">
                                        <p class=" mb-0">Bupati / Walikota</p>
                                        <p class="mb-0"><strong>7280</strong></p>
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
@push('scripts')
<script>
    function confirmDelete(id, dataName) {
        Swal.fire({
            title: 'Anda yakin?',
            text: "Anda akan menghapus Kelompok " + dataName + " dari database!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Tidak, batal!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm-' + id).submit();
            }
        });
    }
</script>
@endpush