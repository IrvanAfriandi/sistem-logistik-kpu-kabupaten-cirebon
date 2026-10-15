@extends("layouts.layouts_admin.users.users_admin")
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
        <h3>Tambah Admin</h3>
        <p class="text-subtitle text-muted">
          Komisi Pemilihan Umum Kabupaten Cirebon
        </p>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
      </div>
    </div>
  </div>

  <!-- Form Tambah Pengguna -->
  <section id="multiple-column-form">
    <div class="row match-height">
      <div class="col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <form class="form" data-parsley-validate action="{{ route('users_admin.store') }}" method="POST">
                @csrf  
                <div class="row">
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label for="name" class="form-label">Nama</label>
                      <input
                        type="text"
                        id="nama"
                        class="form-control"
                        name="nama"
                        placeholder="Nama Lengkap"
                        data-parsley-required="true"
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label for="email" class="form-label">Email</label>
                      <input
                        type="email"
                        id="email"
                        class="form-control"
                        name="email"
                        placeholder="Email"
                        data-parsley-required="true"
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input
                            type="password"
                            id="password"
                            class="form-control"
                            name="password"
                            placeholder="Password"
                            data-parsley-required="true"
                        />
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Ulangi Password</label>
                        <input
                            type="password"
                            id="password_confirmation"
                            class="form-control"
                            name="password_confirmation"
                            placeholder="Ulangi Password"
                            data-parsley-required="true"
                            data-parsley-equalto="#password"/>
                    </div>
                </div>
                  <div class="col-md-6 col-12">
                      <div class="form-group">
                          <input
                              type="hidden"
                              name="role"
                              value="admin"
                          />
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary me-1 mb-1"> Submit </button>
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
