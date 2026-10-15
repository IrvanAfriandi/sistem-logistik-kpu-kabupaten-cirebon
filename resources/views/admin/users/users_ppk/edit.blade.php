@extends("layouts.layouts_admin.users.users_ppk")
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
                        <h3>Profil PPK</h3>
                        <p class="text-subtitle text-muted">Komisi Pemilihan Umum Kabupaten Cirebon</p>
                    </div>
                </div>
            </div>
            <section class="section">
                <form class="form" action="{{ route('users_ppk.update', $users_ppk->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf 
                    @method('PUT') 
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <!-- Menampilkan gambar profil -->
                                        <img src="{{ asset('images/' . ($users_ppk->foto ? $users_ppk->foto : 'user.jpg')) }}" 
                                            class="rounded-circle border border-dark shadow-lg" 
                                            alt="Foto Profil" width="250" height="250" id="profile-photo">
                                    </div>

                                    <!-- Ganti Foto Profil -->
                                    <div class="form-group">
                                        <label for="foto">Ganti Foto Profil</label>
                                        <input type="file" class="form-control" name="foto" id="foto" accept="image/*">
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group has-icon-left">
                                            <label for="email-id-icon" style="text-align: left; display: block;">Email</label>
                                            <div class="position-relative d-flex align-items-center">
                                                <input type="email" class="form-control" value="{{ $users_ppk->email }}" id="email" name="email">
                                                <div class="form-control-icon">
                                                    <i class="bi bi-envelope"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group has-icon-left">
                                            <label for="password-id-icon" style="text-align: left; display: block;">Password</label>
                                            <div class="position-relative d-flex align-items-center">
                                                <input type="password" class="form-control" placeholder="Kosongkan jika tidak ingin diubah" id="password" name="password">
                                                <div class="form-control-icon">
                                                    <i class="bi bi-lock"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $users_ppk->nama }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                            <option value="Laki-laki" {{ $users_ppk->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ $users_ppk->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="umur">Umur</label>
                                        <input type="number" class="form-control" id="umur" name="umur" value="{{ $users_ppk->umur }}" placeholder="Belum diatur">
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $users_ppk->alamat }}" placeholder="Belum diatur">
                                    </div>
                                    <div class="form-group">
                                        <label for="no_telepon">No Telepon</label>
                                        <input type="number" class="form-control" id="no_telepon" name="no_telepon" value="{{ $users_ppk->no_telepon }}" placeholder="Belum diatur">
                                    </div>
                                    <div class="form-group">
                                        <label for="id_kecamatan">Kecamatan</label>
                                        <select id="id_kecamatan" class="form-control" name="id_kecamatan" data-parsley-required="true">
                                            @foreach($kecamatanList as $kecamatan)
                                                <option value="{{ $kecamatan->id_kecamatan }}" 
                                                    {{ $users_ppk->id_kecamatan == $kecamatan->id_kecamatan ? 'selected' : '' }}>
                                                    {{ $kecamatan->nama_kecamatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="jabatan">Jabatan</label>
                                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $users_ppk->jabatan }}" placeholder="Belum diatur">
                                    </div>
                                    <div class="d-flex justify-content-center mt-4">
                                        <button type="submit" class="btn btn-primary me-1 mb-1"> Simpan </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
@endsection

@push('scripts')
<script>
    // Menangani perubahan file foto dengan AJAX
    $('#foto').change(function(e) {
        var reader = new FileReader();
        reader.onload = function(event) {
            // Mengubah foto yang ditampilkan di halaman
            $('#profile-photo').attr('src', event.target.result);
        };
        // Membaca file yang dipilih
        reader.readAsDataURL(e.target.files[0]);
    });
</script>
@endpush
