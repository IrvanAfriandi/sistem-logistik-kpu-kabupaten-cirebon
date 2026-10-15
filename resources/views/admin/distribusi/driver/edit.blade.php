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
        <h3>Edit Data Driver</h3>
        <p class="text-subtitle text-muted">
          Komisi Pemilihan Umum Kabupaten Cirebon
        </p>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav
          aria-label="breadcrumb"
          class="breadcrumb-header float-start float-lg-end"
        >
        </nav>
      </div>
    </div>
  </div>
  <section id="multiple-column-form">
    <div class="row match-height">
      <div class="col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <form action="{{ route('driver.update', $driver->id_driver) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                      <label for="nama_driver">Nama Driver</label>
                      <input type="text" class="form-control" name="nama_driver" value="{{ $driver->nama_driver }}" required>
                  </div>
                  <div class="form-group">
                      <label for="jenis_kelamin">Jenis Kelamin</label>
                      <input type="text" class="form-control" name="jenis_kelamin" value="{{ $driver->jenis_kelamin }}" required>
                  </div>
                  <div class="form-group">
                      <label for="umur">umur</label>
                      <input type="text" class="form-control" name="umur" value="{{ $driver->umur }}" required>
                  </div>
                  <div class="form-group">
                      <label for="no_telepon">no_telepon</label>
                      <input type="text" class="form-control" name="no_telepon" value="{{ $driver->no_telepon }}" required>
                  </div>
                  <div class="form-group">
                      <label for="alamat_driver">alamat_driver</label>
                      <input type="text" class="form-control" name="alamat_driver" value="{{ $driver->alamat_driver }}" required>
                  </div>
                  <div class="form-group">
                      <label for="foto">foto</label>
                      <input type="file" class="form-control" name="foto" value="{{ $driver->foto }}" required>
                  </div>
                  <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                      <button type="submit" class="btn btn-primary me-1 mb-1"> Update </button>
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