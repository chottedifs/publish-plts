<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            {{-- Menu Administrator --}}
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href=""><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                </li>
                <li class="menu-title">MASTER DATA</li><!-- /.menu-title -->
                @can('admin')
                    <li class="">
                        <a href="{{ route('master-petugas.index') }}"> <i class="menu-icon fa fa-list"></i>MASTER PETUGAS</a>
                    </li>
                    <li class="">
                        <a href="{{ route('master-admin.index') }}"> <i class="menu-icon fa fa-plus"></i>MASTER ADMIN</a>
                    </li>
                    <li class="">
                        <a href="{{ route('master-kios.index') }}"> <i class="menu-icon fa fa-list"></i>MASTER KIOS</a>
                    </li>
                    <li class="">
                        <a href="{{ route('master-lokasi.index') }}"> <i class="menu-icon fa fa-plus"></i>MASTER LOKASI</a>
                    </li>
                    <li class="">
                        <a href="{{ route('master-tarifKios.index') }}"> <i class="menu-icon fa fa-plus"></i>MASTER TARIF KIOS</a>
                    </li>
                    <li class="">
                        <a href="{{ route('master-tarifKwh.index') }}"> <i class="menu-icon fa fa-plus"></i>MASTER TARIF KWH</a>
                    </li>
                @endcan
                <li class="">
                    <a href="{{ route('master-user.index') }}"> <i class="menu-icon fa fa-plus"></i>MASTER USER</a>
                </li>

                <li class="menu-title">MANAGEMENT KIOS</li><!-- /.menu-title -->
                <li class="">
                    <a href="{{ route('master-relasiKios.index') }}"> <i class="menu-icon fa fa-plus"></i>DATA KIOS</a>
                </li>
                <li class="">
                    <a href="{{ route('sewa-kios.index') }}"> <i class="menu-icon fa fa-plus"></i>DATA PENYEWA KIOS</a>
                </li>
                <li class="">
                    <a href="{{ route('histori-sewa') }}"> <i class="menu-icon fa fa-plus"></i>DATA RIWAYAT KIOS</a>
                </li>
                <li class="menu-title">KEUANGAN</li><!-- /.menu-title -->
                <li class="">
                    <a href="#"> <i class="menu-icon fa fa-list"></i>TAGIHAN KIOS</a>
                </li>
                <li class="">
                    <a href="#"> <i class="menu-icon fa fa-list"></i>HISTORI TAGIHAN</a>
                </li>

                <li class="menu-title">Dan Lainnya</li><!-- /.menu-title -->
                <li class="">
                    <a href="{{ route('master-informasi.index') }}"> <i class="menu-icon fa fa-plus"></i>BUAT INFORMASI</a>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>
