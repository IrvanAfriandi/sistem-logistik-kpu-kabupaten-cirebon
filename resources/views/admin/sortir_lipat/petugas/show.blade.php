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
        <h3>Informasi Petugas Sorlip</h3>
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
                <div class="row">
                  <div class="col-md-6 col-12 d-flex justify-content-center align-items-center">
                    <div class="form-group">
                      <div class="mb-3">
                        <img src="{{ asset('images/user.jpg') }}" class="rounded-circle border border-dark shadow-lg mb-10 "  alt="Foto Profil" width="250" height="250" id="profile-photo">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <div class="form-group">
                          <label for="nama">Nama</label>
                          <input disabled type="text" class="form-control" id="Nama" name="nama" value="{{ $petugas->nama }}">
                      </div>
                      <div class="form-group">
                          <label for="kelompok">Kelompok</label>
                          <input disabled type="text" class="form-control" id="kelompok" name="kelompok" value="{{ $petugas->kelompok }}">
                      </div>
                      <div class="form-group">
                          <label for="nik">Nomor Induk Kependudukan</label>
                          <input disabled type="text" class="form-control" id="nik" name="nik" value="{{ $petugas->nik }}">
                      </div>
                      <div class="form-group">
                          <label for="umur">Umur</label>
                          <input disabled type="text" class="form-control" id="umur" name="umur" value="{{ $petugas->umur }}">
                      </div>
                      <div class="form-group">
                          <label for="jenis_kelamin">Jenis Kelamin</label>
                          <input disabled type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin" value="{{ $petugas->jenis_kelamin }}">
                      </div>
                      <div class="form-group">
                          <label for="alamat">Alamat</label>
                          <input disabled type="textarea" class="form-control" id="alamat" name="alamat" value="{{ $petugas->alamat }}">
                      </div>
                      <div class="form-group">
                          <label for="telepon">Nomor Telepon</label>
                          <input disabled type="text" class="form-control" id="telepon" name="telepon" value="{{ $petugas->telepon }}">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
      </div>
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <label for="city-column" class="form-label text-bold mb-10" style="font-weight: bold; text-align: center; display: block;">
                  Detail Box yang Disorlip
              </label>
                <table class="custom-table mb-10">
                  <thead>
                      <tr>
                          <th scope="col">No</th>
                          <th scope="col" style="width:120px;">Nomor Box</th>
                          <th scope="col">Jenis Surat Suara</th>
                          <th scope="col">Jumlah Disorlip</th>
                          <th scope="col" style="width:200px;">Waktu Selesai Sorlip</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($sorlip_data as $petugas_sorlip)
                          <tr>
                              <td>
                                  {{ $loop->iteration }}
                              </td>
                              <td>
                                  {{ $petugas_sorlip->box_id->nomor_box }}
                              </td>
                              <td>
                                  {{ $petugas_sorlip->box_id->jenis_surat ? $petugas_sorlip->box_id->jenis_surat->nama_jenis_surat_suara : 'Tidak Diketahui' }}
                              </td>
                              <td>
                                  <input class="form-control" value="{{ $petugas_sorlip->isi_setelah_disorlip }}" disabled/>
                              </td>
                              <td>
                                  {{ $petugas_sorlip->waktu_selesai }}
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