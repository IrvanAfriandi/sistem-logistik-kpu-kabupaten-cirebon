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
            <h3>Informasi Petugas Sorlip</h3>
            <p class="text-subtitle text-muted">
                Komisi Pemilihan Umum Kabupaten Cirebon
            </p>
        </div>
        
    </div>
</div>

  <section id="multiple-column-form">
    <div class="row match-height">
      </div>
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="card-body">
                  <div style="display: flex; flex-direction: column; align-items: flex-start;">
                      <div style="display: flex; gap: 10px; text-align: left;">
                          <span style="min-width: 200px; font-weight: bold;">Nama</span> 
                          <span style="font-weight: bold;">:  {{ $petugas->nama }}</span>
                      </div>
                      <div style="display: flex; gap: 10px; text-align: left;">
                          <span style="min-width: 200px; font-weight: bold;">Kelompok</span> 
                          <span style="font-weight: bold;">:  {{ $petugas->kelompok_sorlip->nama_kelompok }}</span>
                      </div>
                      <div style="display: flex; gap: 10px; text-align: left;">
                          <span style="min-width: 200px; font-weight: bold;">Total Box Disorlip</span> 
                          <span style="font-weight: bold;">:  {{ $total_box_disorlip[$petugas->id_petugas] ?? 0 }}</span>
                      </div>
                      <div style="display: flex; gap: 10px; text-align: left;">
                          <span style="min-width: 200px; font-weight: bold;">Total Surat Suara Disorlip</span> 
                          <span style="font-weight: bold;">:  {{ $total_surat_suara_disorlip[$petugas->id_petugas] ?? 0 }}</span>
                      </div>
                  </div>
              </div>
            </div>
              <label for="city-column" class="form-label text-bold" style="font-weight: bold; text-align: center; display: block;">
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