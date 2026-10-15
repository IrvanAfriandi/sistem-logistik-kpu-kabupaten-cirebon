@extends("layouts.layouts_admin.surat_suara.jenis")
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
                  title: 'Error!',
                  text: '{{ $message }}',
                  showConfirmButton: true,
                  confirmButtonText: 'OK',
              });
          </script>
      @endif 
<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>Tambah Data Jenis Surat Suara</h3>
        <p class="text-subtitle text-muted">
          Komisi Pemilihan Umum Kabupaten Cirebon
        </p>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end"></nav>
      </div>
    </div>
  </div>
  <section id="multiple-column-form">
    <div class="row match-height">
      <div class="col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <form class="form" data-parsley-validate action="{{ route('jenis_surat.store') }}" method="POST">
                @csrf  
                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="nama_jenis_surat_suara" class="form-label">Nama Jenis Surat Suara</label>
                      <input type="text" id="nama_jenis_surat_suara" class="form-control" name="nama_jenis_surat_suara" placeholder="Nama Jenis Surat Suara" data-parsley-required="true"/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary me-1 mb-1"> Submit </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
