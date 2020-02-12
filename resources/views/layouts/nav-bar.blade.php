<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex align-items-center">
        <a class="navbar-brand brand-logo text-white font-weight-bold" href="#">School Portal</a>
        <a class="navbar-brand brand-logo-mini text-white font-weight-bold" href="#">S-P</a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center flex-grow-1">
        <h5 class="mb-0 font-weight-medium d-none d-lg-flex">School Portal</h5>
        <ul class="navbar-nav navbar-nav-right ml-auto">
            <li class="nav-item dropdown language-dropdown d-none d-sm-flex align-items-center">
                <a class="nav-link d-flex align-items-center dropdown-toggle" id="LanguageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <div class="d-inline-flex mr-3">
                        <i class="flag-icon flag-icon-us"></i>
                    </div>
                    <span class="profile-text font-weight-normal">English</span>
                </a>
                <div class="dropdown-menu dropdown-menu-left navbar-dropdown py-2" aria-labelledby="LanguageDropdown">
                    <a href="{{ url('/en') }}" class="dropdown-item">
                        <i class="flag-icon flag-icon-us"></i> English </a>
                    <a href="{{ url('/hi') }}" class="dropdown-item">
                        <i class="flag-icon flag-icon-in"></i> Hindi </a>
                    <a href="{{ url('/fr') }}" class="dropdown-item">
                        <i class="flag-icon flag-icon-fr"></i> French </a>
                </div>
            </li>
            <li class="nav-item dropdown d-none d-xl-inline-flex user-dropdown">
                <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <img class="img-xs rounded-circle ml-2" src="{{ asset('assets/img/face.png') }}" alt="Profile image">
                    <span class="font-weight-normal"> {{ Auth::user()->name }} </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <div class="dropdown-header text-center">
                        <p class="mb-1 mt-3">{{ Auth::user()->name }}</p>
                        <p class="font-weight-light text-muted mb-0">{{ Auth::user()->email }}</p>
                    </div>
                    <a class="dropdown-item"><i class="dropdown-item-icon icon-user text-primary"></i> My Profile</a>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="dropdown-item-icon icon-power text-primary"></i> Sign Out
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>
