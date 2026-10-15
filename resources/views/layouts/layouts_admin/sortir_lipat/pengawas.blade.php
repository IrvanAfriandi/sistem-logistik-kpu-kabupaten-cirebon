<!DOCTYPE html>
<html lang="en">
<head>
 @include('includes.header')
</head>
<body>
@include('includes.topnav')
    <div class="sidebar-menu">
        <ul class="menu">
            <li
                class="sidebar-item">
                <a href="{{ route('admin.index')}}" class='sidebar-link'>
                    <i class="bi bi-house-fill"></i>
                    <span>Halaman Utama</span>
                </a>
            </li>
            <li class="sidebar-title">Manajemen Data</li>
            <li
                class="sidebar-item">
                <a href="{{ route('data_kecamatan.index')}}" class='sidebar-link'>
                    <i class="bi bi-exclude"></i>
                    <span>Kecamatan</span>
                </a>
            </li>
            <li
                class="sidebar-item has-sub">
                <a href="" class='sidebar-link'>
                    <i class="bi bi-people-fill"></i>
                    <span>Akun</span>
                </a>
                <ul class="submenu ">
                    <li class="submenu-item  ">
                        <a href="{{ route('users_admin.index')}}" class="submenu-link">Admin</a>
                    </li>
                    <li class="submenu-item  ">
                        <a href="{{ route('users_ppk.index')}}" class="submenu-link">PPK</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-title">Inventory</li>
            <li
                class="sidebar-item has-sub">
                <a href="" class='sidebar-link'>
                    <i class="bi bi-envelope-fill"></i>
                    <span>Surat Suara</span>
                </a>
                <ul class="submenu ">
                    <li class="submenu-item">
                        <a href="{{ route('box.index')}}" class="submenu-link">Box Surat Suara</a>
                    </li>
                    <li class="submenu-item">
                        <a href="{{ route('jenis_surat.index')}}" class="submenu-link">Jenis Surat Suara</a>
                    </li>
                    <li class="submenu-item">
                        <a href="{{ route('kategori_rusak.index')}}" class="submenu-link">Kategori Kerusakan</a>
                    </li>
                </ul>
            </li>
            <li
                class="sidebar-item">
                <a href="{{ route('perlengkapan.index')}}" class='sidebar-link'>
                    <i class="bi bi-clipboard-fill"></i>
                    <span>Perlengkapan Pemilu</span>
                </a>
            </li>
            
            <li class="sidebar-title">Kegiatan</li>
            <li
                class="sidebar-item active has-sub">
                <a href="#" class='sidebar-link'>
                    <i class="bi bi-layers-half"></i>
                    <span>Sortir & Lipat</span>
                </a>
                <ul class="submenu">
                    <li class="submenu-item">
                        <a href="{{ route('sorlip.index')}}" class="submenu-link">Dashboard</a>
                    </li>
                    <li class="submenu-item active">
                        <a href="{{ route('pengawas.index')}}" class="submenu-link">Pengawas Sorlip</a>
                    </li>
                    <li class="submenu-item  ">
                        <a href="{{ route('petugas.index')}}" class="submenu-link">Petugas Sorlip</a>
                    </li>
                </ul>
            </li>
            <li
                class="sidebar-item  has-sub">
                <a href="{{ route('packing.index')}}" class='sidebar-link'>
                    <i class="bi bi-boxes"></i>
                    <span>Set & Packing</span>
                </a>
                <ul class="submenu ">
                    <li class="submenu-item  ">
                        <a href="{{ route('packing.index')}}" class="submenu-link">Dashboard</a>
                    </li>
                    <li class="submenu-item  ">
                        <a href="{{ route('kebutuhan_kecamatan.index')}}" class="submenu-link">Kebutuhan Pemilu Kecamatan</a>
                    </li>
                </ul>
            </li>
            <li
                class="sidebar-item  has-sub">
                <a href="{{ route('packing.index')}}" class='sidebar-link'>
                    <i class="bi bi-truck"></i>
                    <span>Distribusi</span>
                </a>
                <ul class="submenu">
                    <li class="submenu-item  ">
                        <a href="{{ route('distribusi.index')}}" class="submenu-link">Dashboard</a>
                    </li>
                    <li class="submenu-item  ">
                        <a href="{{ route('kendaraan.index')}}" class="submenu-link">Kendaraan Logistik</a>
                    </li>
                    <li class="submenu-item  ">
                        <a href="{{ route('driver.index')}}" class="submenu-link">Driver Logistik</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-title">Log Out</li>
            <li class="sidebar-item">
                <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="button" class="sidebar-link" style="background: none; border: none; width: 100%; text-align: left;">
                        <i class="bi bi-arrow-left-square-fill"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>
@yield('content')
@include('includes.footer')
@stack('scripts')
</body>
</html>