@extends("layouts.layouts_ppk.sorlip")
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
        <h3>Selesaikan Sorlip</h3>
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
              <form action="{{ route('sorlip_pengawas.update', $sorlip->id_sorlip) }}" method="POST">
                  @csrf
                  @method('PUT') <!-- Menggunakan PUT karena kita ingin memperbarui data -->
                  <div class="row">
                    <div class="col-md-6 col-12">
                      <div class="form-group">
                        <label for="city-column" class="form-label">Nama Petugas</label>
                        <input
                          type="text"
                          id="city-column"
                          class="form-control"
                          name="nama"
                          value="{{ $sorlip->petugas_id->nama }}"
                          readonly
                          data-parsley-required="true"
                        />
                      </div>
                    </div>
                    <div class="col-md-6 col-12">
                      <div class="form-group">
                        <label for="country-floating" class="form-label">Kelompok</label>
                        <input
                          type="text"
                          id="country-floating"
                          class="form-control"
                          value="{{ $sorlip->petugas_id->kelompok_sorlip->nama_kelompok }}"
                          data-parsley-required="true"
                          readonly
                          />
                        </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 col-12">
                      <div class="form-group">
                        <label for="city-column" class="form-label">Nama Pengawas</label>
                        <input
                          type="text"
                          id="city-column"
                          class="form-control"
                          name="nama_pengawas"
                          value="{{ $sorlip->petugas_id->kelompok_sorlip->pengawas_id->nama ?? 'Tidak Ada Nama' }}"
                          data-parsley-required="true"
                          readonly
                        />
                      </div>
                    </div>
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="jenis_surat" class="form-label">Jenis Surat Suara</label>
                            <input type="text"
                                    id="country-floating"
                                    class="form-control"
                                    value="{{ $sorlip->box_id->jenis_surat->nama_jenis_surat_suara }}"
                                    data-parsley-required="true"
                                    readonly/>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="isi_box" class="form-label">Isi Awal Box</label>
                            <input type="text" value="{{ $sorlip->box_id->isi_awal }}" id="isi_box" class="form-control" name="isi_box" readonly />
                          </div>
                        </div>
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="nomor_box" class="form-label">Nomor Box</label>
                            <input type="text" value="{{ $sorlip->box_id->nomor_box }}" id="isi_box" class="form-control" readonly />
                            <input type="hidden" name="nomor_box" value="{{ $sorlip->box_id->id_box }}"/>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="city-column" class="form-label">Isi Box Setelah Disorlip</label>
                          <input
                            type="number"
                            id="city-column"
                            class="form-control"
                            name="isi_setelah_disorlip"
                            data-parsley-required="true"
                          />
                        </div>
                      </div>
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="country-floating" class="form-label">Waktu Mulai Sorlip</label>
                          <input
                            type="text"
                            id="country-floating"
                            class="form-control"
                            value="{{ $sorlip->waktu_dibuka }}"
                            data-parsley-required="true"
                            readonly
                            />
                          </div>
                        </div>
                    </div>
                    <label for="city-column" class="form-label text-bold mt-10" style="font-weight: bold; text-align: center; display: block;">
                          Detail Surat Suara Rusak
                      </label>
                        <table class="custom-table mb-10">
                          <thead>
                              <tr>
                                  <th scope="col">Kategori Rusak</th>
                                  <th scope="col">Jumlah Surat Suara Rusak</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($surat_rusak_kategori as $rusak_kategori)
                                  <tr>
                                      <td>
                                          Kategori {{ $loop->iteration }} - {{ $rusak_kategori->nama_kerusakan }}
                                      </td>
                                      <td>
                                          <input
                                              type="number"
                                              class="custom-input"
                                              name="jumlah_rusak[{{ $rusak_kategori->id_kategori_rusak }}]"
                                              value="{{ 
                                                  $surat_rusak->firstWhere('kategori_rusak', $rusak_kategori->id_kategori_rusak)
                                                  ? $surat_rusak->firstWhere('kategori_rusak', $rusak_kategori->id_kategori_rusak)->jumlah_rusak
                                                  : 0 
                                              }}"
                                          />
                                      </td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                    </div>
                  <div class="form-group">
                      <button type="submit" class="btn btn-success">Selesaikan Sorlip</button>
                      <a href="{{ route('sorlip_pengawas.index') }}" class="btn btn-secondary">Batal</a>
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