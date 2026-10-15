@extends("layouts.layouts_admin.sortir_lipat.pengawas")
@section("content")
</div>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
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
        <h3>Tambah Pengawas</h3>
        <p class="text-subtitle text-muted">
          Komisi Pemilihan Umum Kabupaten Cirebon
        </p>
      </div>
    </div>
  </div>
  <section id="multiple-column-form">
    <div class="row match-height">
      <div class="col-12">
        <div class="card">
          <div class="card-content">
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
                                    <form action="{{ route('pengawas_add.update', $user->id) }}" method="POST" style="display:inline;" id="deleteForm-{{ $user->id }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="button" class="btn btn-success btn-sm" onclick="confirmDelete('{{ $user->id }}', '{{ $user->nama }}')">
                                            Jadikan Pengawas
                                        </button>
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
  </section>
</div>
@endsection
@push('scripts')
<script>
    function confirmDelete(id, dataName) {
    Swal.fire({
        title: 'Anda yakin?',
        text: "Anda akan menjadikan " + dataName + " sebagai Pengawas",
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batal!',
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