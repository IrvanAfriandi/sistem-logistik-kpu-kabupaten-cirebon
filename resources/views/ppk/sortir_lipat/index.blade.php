@extends("layouts.layouts_ppk.sorlip")
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
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Kelompok : 1</h5>
                </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-lg">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th class="text-center" style="min-width: 120px;">Total Box</th>
                                        <th class="text-center" style="min-width: 180px;">Total Surat Suara</th>
                                        <th class="text-center">Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($data_petugas as $petugas)
                                    <tr>
                                        <td class="font-bold">{{ $loop->iteration }}</td>
                                        <td class="col-3">
                                            <div class="d-flex">
                                                <p class="font-bold mb-0">{{ $petugas->nama }}</p>
                                            </div>
                                        </td>
                                        <td class="col-auto text-center">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <p class="font-bold mb-0">{{ $total_box_disorlip[$petugas->id_petugas] ?? 0 }}</p>
                                            </div>
                                        </td>

                                        <td class="col-3 text-center">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <p class="font-bold mb-0">{{ $total_surat_suara_disorlip[$petugas->id_petugas] ?? 0 }}</p>
                                            </div>
                                        </td>
                                        <td class="col-3 text-center">
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                @if (isset($status[$petugas->id_petugas]) && $status[$petugas->id_petugas] !== null) 
                                                    <span class="badge bg-warning mb-1">Sedang Sorlip</span>
                                                    <span class="badge bg-danger text-white">Box {{ $status[$petugas->id_petugas]->box_id->nomor_box }}</span>
                                                @else
                                                    <span class="badge bg-secondary mb-1">Tidak Ada Sorlip</span>
                                                @endif
                                            </div>
                                        </td>


                                        <td class="text-center">
                                            <div class="d-flex flex-column align-items-center gap-1">
                                                @if (isset($status[$petugas->id_petugas]) && $status[$petugas->id_petugas] !== null)
                                                    <a href="{{ route('sorlip_pengawas.selesaikan', $status[$petugas->id_petugas]->id_sorlip) }}" class="btn btn-sm btn-success">
                                                        <i data-feather="check"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('sorlip_pengawas.edit', $petugas->id_petugas) }}" class="btn btn-sm btn-success">
                                                        <i data-feather="share"></i>
                                                    </a>
                                                    <a href="{{ route('sorlip_pengawas.show', $petugas->id_petugas) }}" class="btn btn-sm btn-info">
                                                        <i data-feather="info"></i>
                                                    </a>
                                                @endif
                                                
                                            </div>
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