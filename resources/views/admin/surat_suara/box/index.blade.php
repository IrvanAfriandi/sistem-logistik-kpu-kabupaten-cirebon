@extends("layouts.layouts_admin.surat_suara.box")
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
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Informasi Box Surat Suara</h3>
                <p class="text-subtitle text-muted">Komisi Pemilihan Umum Kabupaten Cirebon</p>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('box.create')}}" class="btn icon icon-left btn-success"><i data-feather="file-plus"></i> Tambah Data</a>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Box</th>
                            <th>Jenis Surat Suara</th>
                            <th>Status Box</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $box)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $box->nomor_box }}</td>
                            <td class="text-capitalize">{{ $box->jenis_surat ? $box->jenis_surat->nama_jenis_surat_suara : 'Belum Diatur' }}</td>

                            <td>
                                @if($box->status_box == 0)
                                    <span class="badge text-capitalize" style="background-color: rgb(222, 0, 0); color: white;">
                                        Terkunci
                                    </span>
                                @elseif($box->status_box == 1)
                                    <span class="badge text-capitalize" style="background-color:rgb(27, 216, 27); color: white;">
                                        Terbuka
                                    </span>
                                @elseif($box->status_box == 2)
                                    <span class="badge text-capitalize" style="background-color:rgb(0, 29, 252); color: white;">
                                        Tersorlip
                                    </span>
                                @elseif($box->status_box == 3)
                                    <span class="badge text-capitalize" style="background-color:rgb(164, 0, 210); color: white;">
                                        Sedang Dipacking
                                    </span>
                                @elseif($box->status_box == 4)
                                    <span class="badge text-capitalize" style="background-color:rgb(243, 105, 0); color: white;">
                                        Terpacking
                                    </span>
                                @endif
                                
                            </td>
                            <td class="text-center">
                                <a href="{{ route('box.edit', $box->id_box) }}" class="btn btn-sm btn-warning">
                                    <i data-feather="edit"></i>
                                </a>
                                <a href="{{ route('box.show', $box->id_box) }}" class="btn btn-sm btn-info">
                                    <i data-feather="info"></i>
                                </a>
                                @if($box->status_box < 1 )
                                    <form action="{{ route('box.destroy', $box->id_box) }}" method="POST" style="display:inline;" id="deleteForm-{{ $box->id_box }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $box->id_box }}', '{{ $box->nomor_box }}')"><i data-feather="trash"></i> </button>
                                    </form>
                                @else()
                                    
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
            text: "Anda akan menghapus Box " + dataName + " dari database!",
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