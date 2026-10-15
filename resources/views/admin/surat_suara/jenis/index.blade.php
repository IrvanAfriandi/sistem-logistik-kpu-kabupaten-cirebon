@extends("layouts.layouts_admin.surat_suara.jenis")
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
                <h3>Data Jenis Surat Suara</h3>
                <p class="text-subtitle text-muted">Komisi Pemilihan Umum Kabupaten Cirebon</p>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('jenis_surat.create') }}" class="btn icon icon-left btn-success">
                    <i data-feather="plus"></i> Tambah Data
                </a>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Jenis Surat Suara</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $jenis_surat)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $jenis_surat->nama_jenis_surat_suara }}</td>
                                <td class="text-center">
                                    <a href="{{ route('jenis_surat.edit', $jenis_surat->id_jenis_surat_suara) }}" class="btn btn-warning btn-sm"><i data-feather="edit"></i> </a>
                                    <form action="{{ route('jenis_surat.destroy', $jenis_surat->id_jenis_surat_suara) }}" method="POST" style="display:inline;" id="deleteForm-{{ $jenis_surat->id_jenis_surat_suara }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $jenis_surat->id_jenis_surat_suara }}', '{{ $jenis_surat->nama_jenis_surat_suara }}')"><i data-feather="trash"></i> </button>
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
