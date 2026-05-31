<div class="sidebar" id="sidebar">
    <li class="nav-item {{ Request::is('guest*') ? 'active' : '' }}">
        <a href="{{ route('guest') }}" class="nav-link">
            <i class="bx bx-user-plus"></i>
            <span>Pendaftaran Guest</span>
        </a>
    </li>
    
    <li class="nav-item {{ Request::is('admin*') ? 'active' : '' }}">
        <a href="{{ route('admin') }}" class="nav-link">
            <i class="bx bx-cog"></i>
            <span>Dashboard Admin</span>
        </a>
    </li>
    
    <li class="nav-item {{ Request::is('board*') ? 'active' : '' }}">
        <a href="{{ route('board') }}" class="nav-link">
            <i class="bx bx-desktop"></i>
            <span>Papan Antrian</span>
        </a>
    </li>
</div>
