@extends("layouts.layouts_admin.set_packing.dashboard")
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
                    title: '{{ $message }}',
                    timer: 5000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end',
                    timerProgressBar: true,
                });
            </script>
        @endif  
<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>Data Keperluan Kecamatan {{ $kecamatan->nama_kecamatan }}</h3>
        <p class="text-subtitle text-muted">
          Komisi Pemilihan Umum Kabupaten Cirebon
        </p>
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
              <label for="city-column" class="form-label text-bold" style="font-weight: bold; text-align: center; display: block;">
                      Detail Kebutuhan Surat Suara
                  </label>
                    <table class="custom-table mb-10">
                      <thead>
                          <tr>
                              <th scope="col">Jenis Surat Suara</th>
                              <th scope="col">Jumlah Kebutuhan</th>
                          </tr>
                      </thead>
                      <tbody>
                      @foreach ($kecamatan->kebutuhanSuratSuara as $item)
                          <tr>
                              <td>{{ $item->jenis_surat_suara_id->nama_jenis_surat_suara }}</td>
                              <td>
                                  <input
                                      type="number"
                                      class="custom-input"
                                      name="surat_suara[{{ $item->id_jenis_surat_suara }}][jumlah_kebutuhan_surat_suara]"
                                      value="{{ $item->jumlah_kebutuhan_surat_suara }}"
                                  />
                              </td>
                          </tr>
                      @endforeach
                      </tbody>
                  </table>
                      
                  <label for="city-column" class="form-label text-bold mt-10" style="font-weight: bold; text-align: center; display: block;">
                          Detail Kebutuhan Perlengkapan
                      </label>
                        <table class="custom-table mb-10">
                          <thead>
                              <tr>
                                  <th scope="col">Jenis Perlengkapan</th>
                                  <th scope="col">Jumlah Kebutuhan</th>
                              </tr>
                          </thead>
                          <tbody>
                          @foreach ($kecamatan->kebutuhanPerlengkapan as $item)
                              <tr>
                                  <td>{{ $item->perlengkapan_id->nama_perlengkapan }}</td>
                                  <td>
                                      <input
                                          type="number"
                                          class="custom-input"
                                          name="perlengkapan[{{ $item->id_perlengkapan }}][jumlah_kebutuhan_perlengkapan]"
                                          value="{{ $item->jumlah_kebutuhan_perlengkapan }}"
                                      />
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