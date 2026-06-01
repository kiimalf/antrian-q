<div class="sidebar" id="sidebar">
    <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
        <a href="{{ route('admin.dashboard') }}" class="nav-link">
            <i class="bx bx-cog"></i>
            <span>Dashboard Admin</span>
        </a>
    </li>
    
    <li class="nav-item {{ Request::is('admin/manajemen') ? 'active' : '' }}">
        <a href="{{ route('admin.manajemen') }}" class="nav-link">
            <i class="bx bx-desktop"></i>
            <span>Manajemen Antrian</span>
        </a>
    </li>
</div>
