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
                <a href="" class='sidebar-link'>
                    <i class="bi bi-house-fill"></i>
                    <span>Halaman Utama</span>
                </a>
            </li>
            <li
                class="sidebar-item active">
                <a href="" class='sidebar-link'>
                    <i class="bi bi-clipboard-fill"></i>
                    <span>Keperluan Pemilu</span>
                </a>
            </li>

            @if(auth()->user()->hak_pengawas == 1)
                <li class="sidebar-title">Kegiatan Logistik</li>
                <li class="sidebar-item">
                    <a href="{{ route('sorlip_pengawas.index') }}" class='sidebar-link'>
                        <i class="bi bi-layers-half"></i>
                        <span>Sortir & Lipat</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('surat_suara.index')}}" class='sidebar-link'>
                        <i class="bi bi-boxes"></i>
                        <span>Set & Packing</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('surat_suara.index')}}" class='sidebar-link'>
                        <i class="bi bi-truck"></i>
                        <span>Distribusi</span>
                    </a>
                </li>
            @endif
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