<header id="header" class="header">
    <div class="top-left">
        <div class="navbar-header">
            <img src="{{ asset('assets/template/images/logo.png') }}"alt="" srcset="">
            {{-- <img class="navbar-brand" href="./">ADMIN PLTS</a> --}}
            {{-- <a class="navbar-brand" href="./">ADMIN PLTS</a> --}}
            <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
        </div>
    </div>
    <div class="top-right">
        <div class="header-menu">

            <div class="user-area dropdown float-right">
                <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="user-avatar rounded-circle" src="https://ui-avatars.com/api/?name=Admin" alt="User Avatar">
                </a>

                <div class="user-menu dropdown-menu">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn nav-link"><i class="fa fa-power-off"></i>Logout</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>
