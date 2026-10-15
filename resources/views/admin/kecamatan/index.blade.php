@extends("layouts.layouts_admin.data_kecamatan")
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
                <h3>Data Kecamatan</h3>
                <p class="text-subtitle text-muted">Komisi Pemilihan Umum Kabupaten Cirebon</p>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('data_kecamatan.create') }}" class="btn icon icon-left btn-success">
                    <i data-feather="plus"></i> Tambah Data
                </a>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Kecamatan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_kecamatan as $kecamatan)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $kecamatan->nama_kecamatan }}</td>
                                <td class="text-center">
                                    <a href="{{ route('data_kecamatan.edit', $kecamatan->id_kecamatan) }}" class="btn btn-warning btn-sm"><i data-feather="edit"></i> </a>
                                    <form action="{{ route('data_kecamatan.destroy', $kecamatan->id_kecamatan) }}" method="POST" style="display:inline;" id="deleteForm-{{ $kecamatan->id_kecamatan }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $kecamatan->id_kecamatan }}', '{{ $kecamatan->nama_kecamatan }}')"><i data-feather="trash"></i> </button>
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
