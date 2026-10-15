@extends("layouts.layouts_admin.sortir_lipat.pengawas")
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
        @if ($message = Session::get('error'))
            <script>
                Swal.fire({
                    icon: 'error',
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
                <h3>Data Pengawas Sorlip</h3>
                <p class="text-subtitle text-muted">Komisi Pemilihan Umum Kabupaten Cirebon</p>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('pengawas_add.index') }}" class="btn icon icon-left btn-success">
                    <i data-feather="user-plus"></i> Tambah Pengawas
                </a>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>PPK</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->kecamatan->nama_kecamatan }}</td>
                                <td>
                                    <form action="{{ route('pengawas.update', $user->id) }}" method="POST" style="display:inline;" id="deleteForm-{{ $user->id }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $user->id }}', '{{ $user->nama }}')">
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
        text: "Anda akan memberhentikan " + dataName + " sebagai Pengawas",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Tidak, batal!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            console.log('Form ID: deleteForm-' + id); // Tambahkan log untuk pengecekan
            document.getElementById('deleteForm-' + id).submit();
        }
    });
}


</script>
@endpush