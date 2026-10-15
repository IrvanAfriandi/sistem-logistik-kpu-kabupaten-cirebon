@extends("layouts.layouts_admin.sortir_lipat.petugas")
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
        <h3>Tambah Pengguna</h3>
        <p class="text-subtitle text-muted">
          Komisi Pemilihan Umum Kabupaten Cirebon
        </p>
      </div>
    </div>
  </div>

  <!-- Form Tambah Pengguna -->
  <section id="multiple-column-form">
    <div class="row match-height">
      <div class="col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
            <form action="{{ route('petugas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
                    <div class="mb-3">
                        <label class="form-label">nama:</label>
                        <input type="text" name="nama" class="form-control" placeholder="nama">
                        @error('nama')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                <div class="mb-3">
                    <label class="form-label">jenis_kelamin:</label>
                    <select name="jenis_kelamin" class="form-select mb-3" aria-label="Default select example">
                        <option value="">--pilih jenis_kelamin--</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                        
                    </select>
                    @error('jenis_kelamin')       
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                    <div class="mb-3">
                        <label class="form-label">umur:</label>
                        <input type="text" name="umur" class="form-control" placeholder="umur">
                        @error('umur')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">alamat:</label>
                        <input type="text" name="alamat" class="form-control" placeholder="alamat">
                        @error('alamat')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">telepon:</label>
                        <input type="text" name="telepon" class="form-control" placeholder="telepon">
                        @error('telepon')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">nik:</label>
                        <input type="text" name="nik" class="form-control" placeholder="nik">
                        @error('nik')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">kelompok:</label>
                        <select name="kelompok" class="form-select mb-3" aria-label="Default select example">
                            <option value="">--pilih kelompok--</option>
                            @foreach ($kelompok as $pilihan_kelompok)
                              <option value="{{ $pilihan_kelompok->id_kelompok }}">{{ $pilihan_kelompok->nama_kelompok }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">foto:</label>
                        <input type="text" name="foto" class="form-control" placeholder="foto">
                        @error('foto')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary ml-3">Submit</button>
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
