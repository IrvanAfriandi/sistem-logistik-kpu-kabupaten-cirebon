@extends("layouts.layouts_admin.surat_suara.box")
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
        <h3>Tambah Data Surat Suara</h3>
        <p class="text-subtitle text-muted">
          Komisi Pemilihan Umum Kabupaten Cirebon
        </p>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
      </div>
    </div>
  </div>

  <!-- // Basic multiple Column Form section start -->
  <section id="multiple-column-form">
    <div class="row match-height">
      <div class="col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
            <form class="form" data-parsley-validate action="{{ route('box.store') }}" method="POST" enctype="multipart/form-data">
                @csrf  
                <div class="row">
                  <div class="col-md-6 col-12">
                      <div class="form-group">
                        <label for="city-column" class="form-label">Nomor Box</label>
                        <input
                          type="text"
                          id="city-column"
                          class="form-control"
                          placeholder="Nomor Box Surat Suara"
                          name="nomor_box"
                          data-parsley-required="true"
                        />
                      </div>
                    </div>
                    <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label for="jenis" class="form-label">Jenis Surat Suara</label>
                        <select id="jenis" class="form-control" name="jenis" data-parsley-required="true">
                            <option value="">-- Pilih Jenis Surat Suara --</option>
                            @foreach($jenis as $jenis)
                                <option value="{{ $jenis->id_jenis_surat_suara }}">{{ $jenis->nama_jenis_surat_suara }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label for="country-floating" class="form-label">Isi Box</label>
                      <input
                        type="number"
                        id="country-floating"
                        class="form-control"
                        name="isi_awal"
                        placeholder="Isi Box Surat Suara"
                        data-parsley-required="true"
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label for="country-floating" class="form-label">Ditambahkan Oleh</label>
                      <input
                        type="text"
                        id="country-floating"
                        class="form-control"
                        value="{{ $nama }}"
                        name="ditambahkan_oleh"
                        data-parsley-required="true"
                        readonly
                      />
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