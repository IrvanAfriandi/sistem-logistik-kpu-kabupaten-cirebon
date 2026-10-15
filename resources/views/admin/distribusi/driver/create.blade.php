@extends("layouts.layouts_admin.distribusi.driver")
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
        <h3>Tambah Data Driver</h3>
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
              <form class="form" data-parsley-validate action="{{ route('driver.store') }}" method="POST">
                @csrf  
                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="nama_driver" class="form-label">Nama Perlengkapan</label>
                      <input type="text" id="nama_driver" class="form-control" name="nama_driver" placeholder="Nama Perlengkapan Pemilu" data-parsley-required="true"/>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="jenis_kelamin" class="form-label">jenis_kelamin</label>
                      <input type="text" id="jenis_kelamin" class="form-control" name="jenis_kelamin" placeholder="Jumlah Perlengkapan yang Tersimpan" data-parsley-required="true"/>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="umur" class="form-label">umur</label>
                      <input type="text" id="umur" class="form-control" name="umur" placeholder="Jumlah Perlengkapan yang Tersimpan" data-parsley-required="true"/>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="no_telepon" class="form-label">no_telepon</label>
                      <input type="text" id="no_telepon" class="form-control" name="no_telepon" placeholder="Jumlah Perlengkapan yang Tersimpan" data-parsley-required="true"/>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="alamat_driver" class="form-label">alamat_driver</label>
                      <input type="text" id="alamat_driver" class="form-control" name="alamat_driver" placeholder="Jumlah Perlengkapan yang Tersimpan" data-parsley-required="true"/>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label for="foto" class="form-label">foto</label>
                      <input type="file" id="foto" class="form-control" name="foto" placeholder="Jumlah Perlengkapan yang Tersimpan" data-parsley-required="true"/>
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
