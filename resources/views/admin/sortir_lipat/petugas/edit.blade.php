@extends("layouts.layouts_admin.sortir_lipat.petugas")
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
        <h3>Informasi Data Kelompok Sorlip</h3>
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
              <form action="{{ route('petugas.update', $petugas_sorlip) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                    <div class="mb-3">
                        <label class="form-label">nama:</label>
                        <input type="text" name="nama" value="{{ $petugas_sorlip->nama }}" 
                        class="form-control" placeholder="nama">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">jenis_kelamin:</label>
                        <select name="jenis_kelamin" class="form-select mb-3" aria-label="Default select example">
                            <option value="{{ $petugas_sorlip->jenis_kelamin }}">{{ $petugas_sorlip->jenis_kelamin }}</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                            
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">umur:</label>
                        <input type="text" name="umur" value="{{ $petugas_sorlip->umur }}" 
                        class="form-control" placeholder="umur">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">alamat:</label>
                        <input type="text" name="alamat" value="{{ $petugas_sorlip->alamat }}" 
                        class="form-control" placeholder="alamat">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">telepon:</label>
                        <input type="text" name="telepon" value="{{ $petugas_sorlip->telepon }}" 
                        class="form-control" placeholder="telepon">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">nik:</label>
                        <input type="text" name="nik" value="{{ $petugas_sorlip->nik }}" 
                        class="form-control" placeholder="nik">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">kelompok:</label>
                        <input type="text" name="kelompok" value="{{ $petugas_sorlip->kelompok }}" 
                        class="form-control" placeholder="kelompok">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">foto:</label>
                        <input type="text" name="foto" value="{{ $petugas_sorlip->foto }}" 
                        class="form-control" placeholder="foto">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary ml-3">Submit</button>
                    </div>
                </form>
              </div>
          </div>
      </div>
    </div>
  </section>
</div>
@endsection