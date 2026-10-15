@extends("layouts.layouts_admin.surat_suara")
@section("content")
</div>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>    
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
        <nav
          aria-label="breadcrumb"
          class="breadcrumb-header float-start float-lg-end"
        >
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('petugas_sorlip.index') }}">Surat Suara</a></li>
            <li class="breadcrumb-item active" aria-current="page">
              Tambah Data
            </li>
          </ol>
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
            <form class="form" data-parsley-validate action="{{ route('surat_suara.update',$surat_suara->id_box) }}" method="POST" enctype="multipart/form-data">
                @csrf 
                @method('PUT') 
                <div class="row">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mandatory">
                            

                            </div>
                        </div>
                    </div>
                  <div class="col-md-6 col-12">
                    
                  </div>
                  <div class="col-md-6 col-12">
                    
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label for="city-column" class="form-label">Nomor Box</label>
                      <input
                        type="text"
                        id="city-column"
                        class="form-control"
                        placeholder="nomor_box"
                        value="{{ $surat_suara->nomor_box }}"
                        name="nomor_box"
                        data-parsley-required="true"
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label for="country-floating" class="form-label">Isi Box</label>
                      <input
                        type="text"
                        id="country-floating"
                        class="form-control"
                        name="isi_surat_suara"
                        value="{{ $surat_suara->isi_surat_suara }}"
                        placeholder="isi_surat_suara"
                        data-parsley-required="true"
                      />
                    </div>
                  </div>
                  
                  <div class="col-12">
                    <div class="form-group">
                      <div class="form-check mandatory">
                        <input
                          type="checkbox"
                          id="checkbox5"
                          class="form-check-input"
                          checked
                          data-parsley-required="true"
                          data-parsley-error-message="You have to accept our terms and conditions to proceed."
                        />
                        <label
                          for="checkbox5"
                          class="form-check-label form-label"
                          >I accept these terms and conditions.</label
                        >
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-12 d-flex justify-center">
                    <button type="submit" class="btn btn-primary me-1 mb-1"> Submit </button>
                    <button
                      type="reset"
                      class="btn btn-light-secondary me-1 mb-1"
                    > Reset </button>
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