@extends("layouts.layouts_admin.sortir_lipat.dashboard")
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
        <h3>Edit Data Kelompok Sorlip</h3>
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
              <form action="{{ route('kelompok.update', $kelompok->id_kelompok) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="row">
                    <div class="col-md-6 col-12">
                      <div class="form-group">
                        <label for="city-column" class="form-label">Kelompok</label>
                        <input
                          type="text"
                          id="city-column"
                          class="form-control"
                          name="nama_kelompok"
                          value=" {{ $kelompok->nama_kelompok }} "
                          data-parsley-required="true"
                        />
                      </div>
                    </div>
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="pengawas" class="form-label">Pengawas</label>
                          <select class="form-control" name="pengawas" data-parsley-required="false">
                            @foreach($pengawas as $pengawass)
                                <option value="{{ $pengawass->id }}" 
                                    {{ $kelompok->pengawas == $pengawass->id ? 'selected' : '' }}>
                                    {{ $pengawass->role }} {{ $pengawass->kecamatan->nama_kecamatan }} - {{ $pengawass->nama }}
                                </option>
                            @endforeach
                          </select>
                        </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                      <button type="submit" class="btn btn-primary me-1 mt-10 mb-1"> Update </button>
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