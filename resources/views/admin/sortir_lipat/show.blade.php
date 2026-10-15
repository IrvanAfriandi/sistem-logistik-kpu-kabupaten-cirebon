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
        <h3>Informasi Data Kelompok Sorlip</h3>
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
                    <div class="col-md-6 col-12">
                      <div class="form-group">
                        <label for="city-column" class="form-label">Kelompok</label>
                        <input
                          type="text"
                          id="city-column"
                          class="form-control"
                          name="nama_kelompok"
                          value=" {{ $kelompok->nama_kelompok }} "
                          disabled
                        />
                      </div>
                    </div>
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="pengawas" class="form-label">Pengawas</label>
                          <select class="form-control" name="pengawas" disabled>
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
                  <label for="city-column" class="form-label text-bold mt-10" style="font-weight: bold; text-align: center; display: block;">
                          Detail Anggota Kelompok
                      </label>
                        <table class="custom-table mb-10">
                          <thead>
                              <tr>
                                  <th scope="col">No</th>
                                  <th scope="col" style="width: 280px;">Nama</th>
                                  <th scope="col">Total Box Disorlip</th>
                                  <th scope="col">Total Surat Suara Disorlip</th>
                                  <th scope="col"></th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($petugas as $petugas_sorlip)
                                  <tr>
                                      <td>{{ $loop->iteration }}</td>
                                      <td>{{ $petugas_sorlip->nama }}</td>
                                      <td>
                                          <input
                                              type="number"
                                              class="form-control"
                                              value="{{ $total_box_disorlip[$petugas_sorlip->id_petugas] ?? 0 }}"
                                              disabled
                                          />
                                      </td>
                                      <td>
                                          <input
                                              type="number"
                                              class="form-control"
                                              value="{{ $total_surat_suara_disorlip[$petugas_sorlip->id_petugas] ?? 0 }}"
                                              disabled
                                          />
                                      </td>
                                      <td>
                                        <a href="{{ route('petugas.show', $petugas_sorlip->id_petugas) }}" class="btn btn-sm btn-info"><i data-feather="info"></i> </a>
                                      </td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>


              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection