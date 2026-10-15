<footer>
    <div class="footer clearfix mb-0 text-muted">
        <div class="float-start">
            <p>2025 &copy; Irvan Afriandi</p>
        </div>
        <div class="float-end">
            <p>Crafted<span class="text-danger"></i></span>
                by <a href="https://www.instagram.com/irvan_afnd?igsh=Z2NqYmgxdmxqMG5i">Irvan Afriandi</a></p>
        </div>
    </div>
</footer>
        </div>
    </div>
    <script src="{{ asset('dist/assets/static/js/components/dark.js')}}"></script>
    <script src="{{ asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    
    
    <script src="{{ asset('dist/assets/compiled/js/app.js')}}"></script>
    

    
<!-- Need: Apexcharts -->
<script src="{{ asset('js.js')}}"></script>
<script src="{{ asset('css.css')}}"></script>

<script src="{{ asset('dist/assets/extensions/apexcharts/apexcharts.min.js')}}"></script>
<script src="{{ asset('dist/assets/static/js/pages/dashboard.js')}}"></script>

<script src="{{ asset('dist/assets/extensions/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('dist/assets/extensions/parsleyjs/parsley.min.js')}}"></script>
<script src="{{ asset('dist/assets/static/js/pages/parsley.js')}}"></script>

<script src="{{ asset('dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>

<script src="{{ asset('dist/assets/extensions/simple-datatables/umd/simple-datatables.js')}}"></script>
<script src="{{ asset('dist/assets/static/js/pages/simple-datatables.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.getElementById('infoButton').addEventListener('click', function(event) {
        event.preventDefault(); 
        var myModal = new bootstrap.Modal(document.getElementById('infoModal'));
        myModal.show();
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('dist/assets/extensions/sweetalert2/sweetalert2.min.js')}}"></script>>
<script src="{{ asset('dist/assets/static/js/pages/sweetalert2.js')}}"></script>>
<script>
    document.querySelector('.sidebar-item button').addEventListener('click', function(e) {
        e.preventDefault(); // Mencegah pengiriman form langsung
        
        // Tampilkan SweetAlert2 untuk konfirmasi
        Swal.fire({
            title: 'Yakin ingin keluar?',
            text: 'Anda akan logout dari aplikasi.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, keluar!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form logout jika konfirmasi
                document.getElementById('logoutForm').submit();
            }
        });
    });
</script>

