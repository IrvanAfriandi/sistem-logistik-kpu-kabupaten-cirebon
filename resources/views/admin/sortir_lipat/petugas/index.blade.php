@extends("layouts.layouts_admin.sortir_lipat.petugas")
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
                <h3>Manajemen Petugas Sorlip</h3>
                <p class="text-subtitle text-muted">Komisi Pemilihan Umum Kabupaten Cirebon</p>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('petugas.create') }}" class="btn icon icon-left btn-success">
                    <i data-feather="user-plus"></i> Tambah Petugas
                </a>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Foto</th>
                            <th>Kelompok</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($petugas as $petugas_sortir)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $petugas_sortir->nama }}</td>
                                <td>
                                    <img src="{{ asset('images/' . ($petugas_sortir->foto && file_exists(public_path('images/' . $petugas_sortir->foto)) ? $petugas_sortir->foto : 'user.jpg')) }}"  alt="Image" width="100" height="100">
                                </td>
                                <td>{{ $petugas_sortir->kelompok ? $petugas_sortir->kelompok : 'Belum ada kelompok' }}</td>
                                <td>
                                    <a href="{{ route('petugas.edit', $petugas_sortir->id_petugas) }}" class="btn btn-sm btn-warning">
                                        <i data-feather="edit"></i>
                                    </a>
                                    <form action="{{ route('petugas.destroy', $petugas_sortir->id_petugas) }}" method="POST" style="display:inline;" id="deleteForm-{{ $petugas_sortir->id_petugas }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $petugas_sortir->id_petugas }}', '{{ $petugas_sortir->nama }}')">
                                            <i data-feather="trash"></i> 
                                        </button>
                                    </form>
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
            text: "Anda akan menghapus " + dataName + " dari database!",
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
