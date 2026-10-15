@extends("layouts.layouts_admin.users.users_admin")
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
                <h3>Profil Admin</h3>
                <p class="text-subtitle text-muted">Komisi Pemilihan Umum Kabupaten Cirebon</p>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
            <!-- Profil Akun -->
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body text-center">
                        <!-- Foto Profil -->
                        <div class="mb-3">
                            <img src="{{ asset('dist/assets/compiled/svg/kpu.svg') }}" 
                                class="rounded-circle border border-dark shadow-lg" 
                                alt="Foto Profil" width="250" height="250">
                        </div>

                        <!-- Tombol Ganti Foto -->
                        <button class="btn btn-primary mb-3">Ganti Foto</button>
                        <div class="col-12">
                            <div class="form-group has-icon-left">
                                <label for="email-id-icon" style="text-align: left; display: block;">Email</label>
                                <div class="position-relative d-flex align-items-center">
                                    <input type="text" class="form-control" placeholder="Email" id="email-id-icon">
                                    <button class="btn custom-btn">
                                        <i class="bi bi-pencil"></i>
                                    </button>
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
                                    <input type="password" class="form-control" placeholder="Password" id="password-id-icon">
                                    <button class="btn custom-btn">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <div class="form-control-icon">
                                        <i class="bi bi-lock"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Diri -->
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" placeholder="Masukkan nama" value="John Doe">
                        </div>
                        <div class="form-group">
                            <label for="jenis-kelamin">Jenis Kelamin</label>
                            <select class="form-control" id="jenis-kelamin">
                                <option value="Laki-laki" selected>Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="umur">Umur</label>
                            <input type="number" class="form-control" id="umur" placeholder="Masukkan umur" value="25">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" id="alamat" placeholder="Masukkan alamat" value="Jl. Raya No. 1, Jakarta">
                        </div>
                        <div class="form-group">
                            <label for="no-telepon">No Telepon</label>
                            <input type="text" class="form-control" id="no-telepon" placeholder="Masukkan no telepon" value="081234567890">
                        </div>
                        <div class="form-group">
                            <label for="jabatan">Jabatan</label>
                            <input type="text" class="form-control" id="jabatan" placeholder="Masukkan jabatan" value="Manager">
                        </div>
                        <div class="form-group">
                            <label for="afiliasi">Afiliasi</label>
                            <input type="text" class="form-control" id="afiliasi" placeholder="Masukkan afiliasi" value="Perusahaan ABC">
                        </div>
                        <!-- Tombol Edit di bawah -->
                        <div class="d-flex justify-content-center mt-4">
                            <button class="btn custom-btn1">
                                Edit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
