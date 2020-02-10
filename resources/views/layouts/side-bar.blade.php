<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="profile-image">
                <img class="img-xs rounded-circle" src="{{ asset('assets/img/face.png') }}" alt="profile image">
                    <div class="dot-indicator bg-success"></div>
                </div>
                <div class="text-wrapper">
                    <p class="profile-name">{{ Auth::user()->name }}</p>
                    <p class="designation">Administrator</p>
                </div>
            </a>
        </li>
        <li class="nav-item {{ request()->is('/') || request()->is('/home') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/') }}">
                <span class="menu-title">Dashboard</span>
                <i class="icon-screen-desktop menu-icon"></i>
            </a>
        </li>
        <li class="nav-item {{ (request()->is('school') || request()->is('school/*')) ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('school') }}">
                <span class="menu-title">Schools</span>
                <i class="icon-home menu-icon"></i>
            </a>
        </li>
        <li class="nav-item {{ (request()->is('teacher') || request()->is('teacher/*')) ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('teacher') }}">
                <span class="menu-title">Teachers</span>
                <i class="icon-people menu-icon"></i>
            </a>
        </li>
        <li class="nav-item {{ (request()->is('student') || request()->is('student/*')) ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/student') }}">
                <span class="menu-title">Students</span>
                <i class="icon-people menu-icon"></i>
            </a>
        </li>
        <li class="nav-item {{ request()->is('send-mail') ? 'active' : '' }}" href="{{ url('/send-mail') }}">
            <a class="nav-link" href="{{ url('send-mail') }}">
                <span class="menu-title">Send Mail</span>
                <i class="icon-envelope menu-icon"></i>
            </a>
        </li>
        <li class="nav-item {{ (request()->is('department') || request()->is('department/*')) ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('department') }}">
                <span class="menu-title">Department</span>
                <i class="icon-layers menu-icon"></i>
            </a>
        </li>
        <li class="nav-item {{ (request()->is('employee') || request()->is('employee/*')) ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('employee') }}">
                <span class="menu-title">Employee</span>
                <i class="icon-people menu-icon"></i>
            </a>
        </li>
    </ul>
</nav>
