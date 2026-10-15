@extends("layouts.layouts_admin.perlengkapan_pemilu")
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
                <h3>Data Perlengkapan Pemilu</h3>
                <p class="text-subtitle text-muted">Komisi Pemilihan Umum Kabupaten Cirebon</p>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('perlengkapan.create') }}" class="btn icon icon-left btn-success">
                    <i data-feather="plus"></i> Tambah Data
                </a>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Perlengkapan</th>
                            <th>Jumlah Tersimpan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $perlengkapan)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $perlengkapan->nama_perlengkapan }}</td>
                                <td>{{ $perlengkapan->jumlah_tersimpan }}</td>
                                <td class="text-center">
                                    <a href="{{ route('perlengkapan.edit', $perlengkapan->id_perlengkapan) }}" class="btn btn-warning btn-sm"><i data-feather="edit"></i> </a>
                                    <form action="{{ route('perlengkapan.destroy', $perlengkapan->id_perlengkapan) }}" method="POST" style="display:inline;" id="deleteForm-{{ $perlengkapan->id_perlengkapan }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $perlengkapan->id_perlengkapan }}', '{{ $perlengkapan->nama_perlengkapan }}')"><i data-feather="trash"></i> </button>
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
