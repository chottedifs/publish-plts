<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">

            <ul class="nav navbar-nav">

                <!-- /.menu-admin -->
                @can('admin')
                    <!-- /.menu-title -->
                    <li class="menu-title">DASHBOARD</li>
                        <li>
                            <a href="{{ route('dashboard') }}"><i class="menu-icon fa-solid fa-table-columns"></i> Beranda Utama </a>
                        </li>

                    <!-- /.menu-title -->
                    <li class="menu-title">MANAGEMENT KELOLA</li>
                        <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="menu-icon fa fa-user-cog"></i>Master Data User</a>
                            <ul class="sub-menu children dropdown-menu">
                                <li><i class="menu-icon fa fa-user-secret"></i><a href="{{ route('master-admin.index') }}" class="ml-1">Administrator</a></li>
                                <li><i class="menu-icon fa fa-user-tie"></i><a href="{{ route('master-petugas.index') }}" class="ml-1">Operator</a></li>
                                <li><i class="menu-icon fa fa-user-tie"></i><a href="{{ route('master-plts.index') }}" class="ml-1">Admin PLTS</a></li>
                                <li><i class="menu-icon fa fa-user"></i><a href="{{ route('master-user.index') }}" class="ml-1">User Kios</a></li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="menu-icon fa fa-store-alt"></i>Master Data Kios</a>
                            <ul class="sub-menu children dropdown-menu">
                                <li><i class="menu-icon fa fa-store-alt"></i><a href="{{ route('master-kios.index') }}" class="ml-1">Pendaftaran Kios</a></li>
                                <li><i class="menu-icon fa fa-funnel-dollar"></i><a href="{{ route('master-tarifKios.index') }}" class="ml-1">Tarif Kios</a></li>
                                <li><i class="menu-icon fa fa-funnel-dollar"></i><a href="{{ route('master-tarifKwh.index') }}" class="ml-1">Tarif Dasar KWH</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('master-lokasi.index') }}"> <i class="menu-icon fa fa-search-location"></i>Lokasi</a>
                        </li>
                        <li>
                            <a href="{{ route('master-status.index') }}"> <i class="menu-icon fa fa-search-location"></i>Status</a>
                        </li>

                    <!-- /.menu-title -->
                    <li class="menu-title">MANAGEMENT KIOS</li>
                        <li>
                            <a href="{{ route('master-relasiKios.index') }}"> <i class="menu-icon fa fa-store-alt"></i>Data Kios</a>
                        </li>
                        <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="menu-icon fa fa-window-restore"></i>Sewa Kios</a>
                            <ul class="sub-menu children dropdown-menu">
                                <li><i class="menu-icon fa fa-user-tag pr-2"></i> <a href="{{ route('sewa-kios.index') }}" class="ml-1">Data Penyewa Kios</a></li>
                            </ul>
                        </li>

                    <!-- /.menu-title -->
                    <li class="menu-title">KEUANGAN & PEMBAYARAN</li>
                        <li>
                            <a href="{{ route('tagihan-index') }}"> <i class="menu-icon fa fa-file-invoice-dollar"></i>Tagihan</a>
                        </li>
                        <li>
                            <a href="{{ route('historiTagihan') }}"><i class="menu-icon fa fa-history"></i>Transaksi Tagihan</a>
                        </li>
                        <li>
                            <a href="{{ route('pembayaran.index') }}"><i class="menu-icon fa fa-history"></i>Pembayaran</a>
                        </li>

                    <!-- /.menu-title -->
                    <li class="menu-title">Dan Lainnya</li>
                        <li>
                            <a href="{{ route('master-informasi.index') }}"><i class="menu-icon fa fa-info-circle"></i>Informasi</a>
                        </li>
                @endcan

                <!-- /.menu-operator -->
                @can('operator')
                    <!-- /.menu-title -->
                    <li class="menu-title">DASHBOARD</li>
                        <li>
                            <a href="{{ route('dashboard') }}"><i class="menu-icon fa-solid fa-table-columns"></i> Beranda Utama </a>
                        </li>

                    <!-- /.menu-title -->
                    <li class="menu-title">MANAGEMENT USER</li>
                        <li class="">
                            <a href="{{ route('master-user.index') }}"> <i class="menu-icon fa fa-user"></i>Master User</a>
                        </li>
                        <li class="">
                            <a href="{{ route('master-status.index') }}"> <i class="menu-icon fa fa-user"></i>Status</a>
                        </li>

                    <!-- /.menu-title -->
                    <li class="menu-title">MANAGEMENT KIOS</li>
                        <li>
                            <a href="{{ route('master-relasiKios.index') }}"> <i class="menu-icon fa fa-store-alt"></i>Data Kios</a>
                        </li>
                        <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="menu-icon fa fa-window-restore"></i>Sewa Kios</a>
                            <ul class="sub-menu children dropdown-menu">
                                <li><i class="menu-icon fa fa-user-tag pr-2"></i> <a href="{{ route('sewa-kios.index') }}" class="ml-1">Data Penyewa Kios</a></li>
                            </ul>
                        </li>

                    <!-- /.menu-title -->
                    <li class="menu-title">KEUANGAN</li>
                        <li>
                            <a href="{{ route('tagihan-index') }}"> <i class="menu-icon fa fa-file-invoice-dollar"></i>Tagihan</a>
                        </li>
                        <li>
                            <a href="{{ route('historiTagihan') }}"><i class="menu-icon fa fa-history"></i>Transaksi Tagihan</a>
                        </li>
                        <li>
                            <a href="{{ route('pembayaran.index') }}"><i class="menu-icon fa fa-history"></i>Pembayaran</a>
                        </li>

                    <!-- /.menu-title -->
                    <li class="menu-title">Dan Lainnya</li>
                        <li class="">
                            <a href="{{ route('master-informasi.index') }}"><i class="menu-icon fa fa-info-circle"></i>Informasi</a>
                        </li>
                @endcan

                @can('plts')
                <!-- /.menu-title -->
                <li class="menu-title">DASHBOARD</li>
                    <li>
                        <a href="{{ route('dashboard') }}"><i class="menu-icon fa-solid fa-table-columns"></i> Beranda Utama </a>
                    </li>
                <li class="menu-title">MANAGEMENT KELOLA</li>
                    <li>
                        <a href="{{ route('master-tarifKwh.index') }}"><i class="menu-icon fa fa-funnel-dollar"></i> Tarif Dasar KWH </a>
                    </li>
                <li class="menu-title">KEUANGAN & PEMBAYARAN</li>
                    <li>
                        <a href="{{ route('tagihan-index') }}"><i class="menu-icon fa fa-file-invoice-dollar"></i> Tagihan </a>
                    </li>
                @endcan


            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>
