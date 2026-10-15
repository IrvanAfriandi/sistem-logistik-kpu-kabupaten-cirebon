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
        <h3>Mulai Sortir dan Lipat</h3>
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
              <form class="form" data-parsley-validate action="{{ route('sorlip_pengawas.store') }}" method="POST">
                @csrf 
                <div class="row">
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label for="city-column" class="form-label">Nama Petugas</label>
                      <input
                        type="text"
                        id="city-column"
                        class="form-control"
                        name="nama"
                        value="{{ $info_petugas->nama }}"
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
                        value="{{ $info_petugas->kelompok_sorlip->nama_kelompok }}"
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
                        placeholder="Nomor Box Surat Suara"
                        value="{{ $info_petugas->kelompok_sorlip->pengawas_id->nama ?? 'Tidak Ada Nama' }}"
                        data-parsley-required="true"
                        readonly
                      />
                    </div>
                  </div>
                    <div class="col-md-6 col-12">
                      <div class="form-group">
                          <label for="jenis_surat" class="form-label">Jenis Surat Suara</label>
                          <select id="jenis_surat" class="form-control" name="jenis_surat" required>
                              <option value="">Pilih Jenis Surat</option>
                              @foreach($jenisSurat as $jenis)
                                  <option value="{{ $jenis->id_jenis_surat_suara }}">{{ $jenis->nama_jenis_surat_suara }}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
                  <div class="col-md-6 col-12">
                      <div class="form-group">
                          <label for="isi_box" class="form-label">Isi Box</label>
                          <input type="text" placeholder="Pilih Nomor Box Dahulu..." id="isi_box" class="form-control" name="isi_box" readonly />
                      </div>
                  </div>
                  <div class="col-md-6 col-12">
                      <div class="form-group">
                          <label for="nomor_box" class="form-label">Nomor Box</label>
                          <select id="nomor_box" class="form-control" name="nomor_box" required>
                              <option value="">Pilih Nomor Box Dahulu...</option>
                          </select>
                      </div>
                  </div>
                </div>

                <input type="hidden" name="id_pengawas" value="{{ $info_petugas->kelompok_sorlip->pengawas_id->id ?? 'Tidak Ada' }}"/>
                <input type="hidden" name="nama_pengawas" value="{{ $info_petugas->kelompok_sorlip->pengawas_id->nama ?? 'Tidak Ada' }}"/>
                <input type="hidden" name="id_petugas" value="{{ $info_petugas->id_petugas }}"/>

                <div class="row">
                  <div class="col-12 d-flex justify-content-center">
                    <button type="submit" class="btn btn-success me-1 mt-10 mb-1">Mulai Sorlip</button>
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
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#jenis_surat').change(function() {
            let jenisId = $(this).val();
            console.log("Jenis Surat Dipilih:", jenisId); // Cek apakah event berjalan

            if (jenisId) {
                $.ajax({
                    url: "/get-boxes/" + jenisId,
                    type: "GET",
                    dataType: "json",
                    beforeSend: function() {
                        console.log("Mengambil data box..."); // Debug
                        $('#nomor_box').html('<option value="">Loading...</option>'); // Tampilkan loading
                    },
                    success: function(data) {
                        console.log("Data Box Diterima:", data); // Debug
                        $('#nomor_box').empty().append('<option value="">Pilih Box</option>');
                        $.each(data, function(key, value) {
                            $('#nomor_box').append(`<option value="${value.id_box}">${value.nomor_box}</option>`);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error AJAX:", error); // Debug jika error
                        alert("Terjadi kesalahan saat mengambil data box!");
                    }
                });
            } else {
                $('#nomor_box').html('<option value="">Pilih Jenis Surat Dulu</option>');
            }
        });

        $('#nomor_box').change(function() {
            let boxId = $(this).val();
            console.log("Box Dipilih:", boxId); // Debug

            if (boxId) {
                $.ajax({
                    url: "/get-box-detail/" + boxId,
                    type: "GET",
                    dataType: "json",
                    beforeSend: function() {
                        console.log("Mengambil isi box...");
                        $('#isi_box').val('Loading...');
                    },
                    success: function(data) {
                        console.log("Isi Box Diterima:", data);
                        $('#isi_box').val(data.isi_awal);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error AJAX:", error);
                        alert("Terjadi kesalahan saat mengambil isi box!");
                    }
                });
            } else {
                $('#isi_box').val('');
            }
        });
    });
</script>
@endpush