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
        <h3>Informasi Data Box Surat Suara</h3>
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
                      <label for="city-column" class="form-label">Nomor Box</label>
                      <input
                        type="text"
                        class="form-control"
                        value="{{ $box->nomor_box }}"
                        disabled/>
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label for="jenis" class="form-label">Jenis Surat Suara</label>
                      <input
                        type="text"
                        class="form-control"
                        value="{{ $box->jenis_surat->nama_jenis_surat_suara }}"
                        disabled/>
                    </div>
                </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label for="country-floating" class="form-label">Isi Awal Box</label>
                      <input
                        type="number"
                        class="form-control"
                        value="{{ $box->isi_awal }}"
                        disabled/>
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                   <div class="form-group">
                    <div id="status-awal" data-status-box="{{ $box->status_box }}"></div>
                      <label for="status-box" class="form-label">Status Box</label>
                        <select
                            id="status-box"
                            class="form-control"
                            name="status_box"
                            disabled>
                            <option value="0" {{ $box->status_box == 0 ? 'selected' : '' }}>Terkunci</option>
                            <option value="1" {{ $box->status_box == 1 ? 'selected' : '' }}>Terbuka</option>
                            <option value="2" {{ $box->status_box == 2 ? 'selected' : '' }}>Tersorlip</option>
                            <option value="3" {{ $box->status_box == 3 ? 'selected' : '' }}>Sedang Dipacking</option>
                            <option value="4" {{ $box->status_box == 4 ? 'selected' : '' }}>Terpacking</option>
                        </select>
                    </div>
                  </div>

                <div id="tambahan">
                    <div id="tambahan1" style="display:none;">
                      <div class="row">
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="city-column" class="form-label">Waktu Dibuka</label>
                            <input
                              type="datetime-local"
                              id="required1"
                              class="form-control"
                              name="waktu_dibuka"
                              disabled
                              value="{{ $sorlip && $sorlip->waktu_dibuka ? $sorlip->waktu_dibuka : '' }}"
                              data-parsley-required="false"/>
                          </div>
                        </div>
                          <div class="col-md-6 col-12">
                            <div class="form-group">
                              <label for="dibuka_oleh" class="form-label">Dibuka Oleh</label>
                              <select disabled id="required1" class="form-control" name="dibuka_oleh" data-parsley-required="false">
                                  @if($sorlip && $sorlip->dibuka_oleh == null)
                                      <option value="{{ $nama }}" selected>{{ $nama }}</option>
                                  @elseif($sorlip)
                                      <option value="{{ $sorlip->dibuka_oleh }}" selected>{{ $sorlip->dibuka_oleh }}</option>
                                  @endif
                                  @foreach($pengawas as $admin)
                                      <option value="{{ $admin->nama }}">
                                          @if($admin->role == 'Admin')
                                              {{ $admin->nama }} - {{ $admin->role }}
                                          @elseif($admin->role == 'PPK')
                                              {{ $admin->nama }} - {{ $admin->role }} {{ $admin->kecamatan->nama_kecamatan }}
                                          @endif
                                      </option>
                                  @endforeach
                              </select>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div id="tambahan2" style="display:none;">
                      <div class="row">

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                              <label for="petugas" class="form-label">Petugas Sorlip</label>
                              <select disabled id="required2" class="form-control" name="petugas" data-parsley-required="false">
                                <option value="" {{ is_null($sorlip) ? 'selected' : '' }}>-- Pilih Petugas --</option>
                                  @foreach($petugas_list as $petugas)
                                      <option value="{{ $petugas->id_petugas }}" 
                                          {{ ($sorlip && $sorlip->petugas == $petugas->id_petugas) ? 'selected' : '' }}>
                                          {{ $petugas->nama }} - Kelompok {{ $petugas->kelompok }}
                                      </option>
                                  @endforeach
                              </select>
                            </div>
                          </div>
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="diselesaikan_oleh" class="form-label">Pengawas Sorlip</label>
                            <select disabled id="required2" class="form-control" name="diselesaikan_oleh" data-parsley-required="false">
                              <option value="" {{ is_null($sorlip) ? 'selected' : '' }}>-- Pilih Pengawas --</option>
                                @foreach($pengawas as $pengawas_sorlip)
                                    <option value="{{ $pengawas_sorlip->nama }}" 
                                        {{ ($sorlip && $sorlip->diselesaikan_oleh == $pengawas_sorlip->nama) ? 'selected' : '' }}>
                                        @if($pengawas_sorlip->role == 'Admin')
                                            {{ $pengawas_sorlip->nama }} - {{ $pengawas_sorlip->role }}
                                        @elseif($pengawas_sorlip->role == 'PPK')
                                            {{ $pengawas_sorlip->nama }} - {{ $pengawas_sorlip->role }} {{ $pengawas_sorlip->kecamatan->nama_kecamatan }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="city-column" class="form-label">Isi Box Setelah Disorlip</label>
                            <input
                              disabled
                              type="number"
                              id="required2"
                              class="form-control"
                              name="isi_setelah_disorlip"
                              value="{{ $sorlip && $sorlip->isi_setelah_disorlip ? $sorlip->isi_setelah_disorlip : '0' }}"
                              data-parsley-required="false"
                            />
                          </div>
                        </div>
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="city-column" class="form-label">Waktu Box Tersorlip</label>
                            <input
                              disabled
                              type="datetime-local"
                              id="required2"
                              class="form-control"
                              name="waktu_selesai"
                              value="{{ $sorlip && $sorlip->waktu_selesai ? $sorlip->waktu_selesai : '' }}"
                              data-parsley-required="false"
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
                                              disabled
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
                    <div id="tambahan3" style="display:none;">
                      <div class="row">
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="mulai_packing_oleh" class="form-label">Dimulai Packing Oleh</label>
                            <select disabled id="required3" class="form-control" name="mulai_packing_oleh" data-parsley-required="false">
                              <option value="" {{ is_null($packing->mulai_packing_oleh) ? 'selected' : '' }}>-- Pilih --</option>
                                @foreach($ppk as $operator)
                                    <option value="{{ $operator->nama }}" 
                                        {{ ($packing && $packing->mulai_packing_oleh == $operator->nama) ? 'selected' : '' }}>
                                        @if($operator->role == 'Admin')
                                            {{ $operator->nama }} - {{ $operator->role }}
                                        @elseif($operator->role == 'PPK')
                                            {{ $operator->nama }} - {{ $operator->role }} {{ $operator->kecamatan->nama_kecamatan }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="city-column" class="form-label">Waktu Dimulai Packing</label>
                            <input
                              type="datetime-local"
                              disabled
                              id="required3"
                              class="form-control"
                              name="waktu_mulai_packing"
                              value="{{ $packing && $packing->waktu_mulai_packing ? $packing->waktu_mulai_packing : '' }}"
                              data-parsley-required="false"
                            />
                          </div>
                        </div> 
                      </div>
                    </div>

                    <div id="tambahan4" style="display:none;">
                      <div class="row">
                      <label for="city-column" class="form-label text-bold mt-10" style="font-weight: bold; text-align: center; display: block;">
                          Detail Packing Box Surat Suara
                      </label>

                          <table class="custom-table mb-10">
                            <thead>
                                <tr>
                                    <th scope="col">Kecamatan</th>
                                    <th scope="col">Jumlah Diambil</th>
                                    <th scope="col">Sisa</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody id="dynamic-fields">
                                @if($packing_detail != null && count($packing_detail) > 0)
                                    @foreach($packing_detail as $detail_box)
                                        <tr>
                                            <td>
                                              <select disabled name="kecamatan[{{ $detail_box->kecamatan }}]" class="form-control">
                                                  <option value="">-- Pilih Kecamatan --</option>
                                                  @foreach($kecamatanList as $listkecamatan)
                                                      <option value="{{ $listkecamatan->id_kecamatan }}" 
                                                          {{ $detail_box->kecamatan == $listkecamatan->id_kecamatan ? 'selected' : '' }}>
                                                          {{ $listkecamatan->nama_kecamatan }}
                                                      </option>
                                                  @endforeach
                                              </select>
                                            </td>
                                            <td>
                                              <input disabled type="number" id="required4" name="isi_dipakai[{{ $detail_box->kecamatan }}]" class="form-control" value="{{ $detail_box->isi_dipakai }}" />
                                            </td>
                                            <td>
                                              <input disabled type="number" id="required4" name="sisa_isi_box[{{ $detail_box->kecamatan }}]" class="form-control" value="{{ $detail_box->sisa_isi_box }}" />
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>
                                            <select disabled name="kecamatan[]" id="required4" class="form-control" data-parsley-required="false">
                                                <option value="">-- Pilih Kecamatan --</option>
                                                @foreach($kecamatanList as $kecamatan)
                                                    <option value="{{ $kecamatan->id_kecamatan }}">
                                                        {{ $kecamatan->nama_kecamatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input disabled id="required4" type="number" name="isi_dipakai[]" class="form-control" value=""/>
                                        </td>
                                        <td>
                                            <input disabled id="required4" type="number" name="sisa_isi_box[]" class="form-control" value=""/>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                          </table>
                        <div class="row">
                          <div class="col-md-6 col-12">
                            <div class="form-group">
                              <label for="selesai_packing_oleh" class="form-label">Packing Diselesaikan Oleh</label>
                              <select disabled id="required4" class="form-control" name="selesai_packing_oleh" data-parsley-required="false">
                                <option value="" {{ is_null($packing->selesai_packing_oleh) ? 'selected' : '' }}>-- Pilih --</option>
                                  @foreach($ppk as $operator)
                                      <option value="{{ $operator->nama }}" 
                                          {{ ($packing && $packing->selesai_packing_oleh == $operator->nama) ? 'selected' : '' }}>
                                          @if($operator->role == 'Admin')
                                              {{ $operator->nama }} - {{ $operator->role }}
                                          @elseif($operator->role == 'PPK')
                                              {{ $operator->nama }} - {{ $operator->role }} {{ $operator->kecamatan->nama_kecamatan }}
                                          @endif
                                      </option>
                                  @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col-md-6 col-12">
                            <div class="form-group">
                              <label for="city-column" class="form-label">Waktu Packing Selesai</label>
                              <input
                                type="datetime-local"
                                disabled
                                id="required4"
                                class="form-control"
                                name="waktu_selesai_packing"
                                value="{{ $packing && $packing->waktu_selesai_packing ? $packing->waktu_selesai_packing : '' }}"
                                data-parsley-required="false"
                              />
                            </div>
                          </div> 
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
@push('scripts')
<script>
  const initialStatusBox = document.getElementById('status-awal').getAttribute('data-status-box');
  function handleStatusChange() {
      const statusBox = document.getElementById('status-box').value;
      const columns = document.querySelectorAll('#tambahan > div');
      columns.forEach(function(col) {
          col.style.display = 'none';
      });
      if (statusBox >= 1) {
          document.getElementById('tambahan1').style.display = 'block';
      }
      if (statusBox >= 2) {
          document.getElementById('tambahan2').style.display = 'block';
      }
      if (statusBox >= 3) {
          document.getElementById('tambahan3').style.display = 'block';
      }
      if (statusBox >= 4) {
          document.getElementById('tambahan4').style.display = 'block';
      }

      const inputRequired1 = document.querySelector('#required1');  // Menangkap input dengan id required1
      const inputRequired2 = document.querySelector('#required2');  // Menangkap input dengan id required2
      const inputRequired3 = document.querySelector('#required3');  // Menangkap input dengan id required2
      const inputRequired4 = document.querySelector('#required4');  // Menangkap input dengan id required2

      // Pengecekan untuk input dengan id 'required1'
      if (statusBox >= 1) {
          inputRequired1.setAttribute('data-parsley-required', 'true');
      } else {
          inputRequired1.setAttribute('data-parsley-required', 'false');
      }

      // Pengecekan untuk input dengan id 'required2'
      if (statusBox >= 2) {
          inputRequired2.setAttribute('data-parsley-required', 'true');
      } else {
          inputRequired2.setAttribute('data-parsley-required', 'false');
      }
      // Pengecekan untuk input dengan id 'required3'
      if (statusBox >= 3) {
          inputRequired3.setAttribute('data-parsley-required', 'true');
      } else {
          inputRequired3.setAttribute('data-parsley-required', 'false');
      }
      // Pengecekan untuk input dengan id 'required3'
      if (statusBox >= 4) {
          inputRequired4.setAttribute('data-parsley-required', 'true');
      } else {
          inputRequired4.setAttribute('data-parsley-required', 'false');
      }

      const options = document.querySelectorAll('#status-box option');
      options.forEach(function(option) {
          if (parseInt(option.value) < initialStatusBox) {
              option.disabled = true;
          } else {
              option.disabled = false;
          }
      });
  }
  window.onload = handleStatusChange;
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Menambahkan event listener untuk tombol tambah baris
        document.getElementById('add-row-btn').addEventListener('click', function() {
            let tbody = document.getElementById('dynamic-fields');
            let newRow = document.createElement('tr');

            // Isi baris baru dengan input form
            newRow.innerHTML = `
                <td>
                    <select name="kecamatan[]" class="form-control">
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach($kecamatanList as $kecamatan)
                            <option value="{{ $kecamatan->id_kecamatan }}">
                                {{ $kecamatan->nama_kecamatan }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="isi_dipakai[]" class="form-control" value=""/>
                </td>
                <td>
                    <input type="number" name="sisa_isi_box[]" class="form-control" value=""/>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row-btn">Hapus</button>
                </td>
            `;

            // Menambahkan baris baru ke dalam tabel
            tbody.appendChild(newRow);

            // Menambahkan event listener baru pada tombol hapus yang baru ditambahkan
            newRow.querySelector('.remove-row-btn').addEventListener('click', function() {
                const inputField = this.closest('tr').querySelector('input[name="isi_dipakai[]"]');
                inputField.value = 0; // Ubah nilai input menjadi 0
                this.closest('tr').style.display = 'none'; // Sembunyikan baris setelah mengubah menjadi 0
            });
        });

        // Mengecek jika jumlah diambil = 0, maka sembunyikan baris
        const rows = document.querySelectorAll('#dynamic-fields tr');
        rows.forEach(function(row) {
            const inputJumlah = row.querySelector('input[name*="isi_dipakai"]');
            if (inputJumlah && parseInt(inputJumlah.value) === 0) {
                row.style.display = 'none'; // Sembunyikan baris jika jumlah diambil = 0
            }
        });
    });
</script>


@endpush