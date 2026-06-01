@extends('layouts.guest')

@section('style-page')
<style>
    .access-card {
        transition: var(--transition) !important;
        border: 1px solid var(--border-color) !important;
        background-color: var(--bg-surface) !important;
    }
    .access-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg) !important;
    }
    .access-card:hover .arrow-icon {
        transform: translateX(5px);
    }
    .arrow-icon {
        transition: var(--transition);
    }
    
    /* Custom colored borders on card hover */
    .card-guest:hover {
        border-color: var(--success) !important;
    }
    .card-admin:hover {
        border-color: var(--primary) !important;
    }
    .card-board:hover {
        border-color: var(--warning) !important;
    }
</style>
@endsection

@section('content')
<div style="max-width: 1100px; margin: 0 auto; padding: 2rem 1.5rem;">
    <!-- Hero Section -->
    <div class="text-center" style="margin-bottom: 4rem; margin-top: 1.5rem;">
        <span class="badge badge-success" style="margin-bottom: 1.25rem; padding: 0.5rem 1rem; font-size: 0.85rem; letter-spacing: 0.05em; text-transform: uppercase;">
            <i class="bx bxs-zap" style="margin-right: 0.25rem;"></i> Server-Sent Events (SSE)
        </span>
        
        <h1 style="font-size: 3rem; font-weight: 800; color: var(--text-primary); line-height: 1.2; margin-bottom: 1.25rem; background: linear-gradient(135deg, var(--text-primary), #3b82f6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            Sistem Antrian Digital Real-Time
        </h1>
        
        <p style="font-size: 1.15rem; color: var(--text-muted); max-width: 750px; margin: 0 auto; line-height: 1.75;">
            Aplikasi ini digunakan untuk mengelola antrian secara real-time. Guest dapat mengambil nomor antrian secara instan, petugas (admin) dapat memanggil dan mengontrol loket, serta board antrian akan menampilkan nomor yang dipanggil secara otomatis dilengkapi notifikasi suara.
        </p>
    </div>

    <!-- Menu Akses Utama -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem; margin-bottom: 4rem;">
        
        <!-- Card 1: Guest -->
        <a href="{{ route('guest') }}" class="card access-card card-guest" style="text-decoration: none; display: flex; flex-direction: column; justify-content: space-between; border-radius: var(--radius-lg); padding: 2.25rem; height: 100%; margin-bottom: 0;">
            <div>
                <div style="width: 56px; height: 56px; border-radius: var(--radius-md); background-color: var(--success-light); display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                    <i class="bx bx-user-plus" style="font-size: 2rem; color: var(--success);"></i>
                </div>
                <h3 style="font-size: 1.35rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.75rem;">Registrasi Guest</h3>
                <p style="color: var(--text-muted); line-height: 1.6; font-size: 0.95rem; margin-bottom: 2rem;">
                    Ambil nomor antrian baru dengan memasukkan nama Anda secara mandiri untuk mendapatkan tiket digital Anda.
                </p>
            </div>
            <div class="d-flex align-center gap-2" style="font-weight: 600; color: var(--success); font-size: 0.95rem;">
                <span>Ambil Tiket</span>
                <i class="bx bx-right-arrow-alt arrow-icon" style="font-size: 1.25rem;"></i>
            </div>
        </a>

        <!-- Card 2: Admin -->
        <a href="{{ route('admin.dashboard') }}" class="card access-card card-admin" style="text-decoration: none; display: flex; flex-direction: column; justify-content: space-between; border-radius: var(--radius-lg); padding: 2.25rem; height: 100%; margin-bottom: 0;">
            <div>
                <div style="width: 56px; height: 56px; border-radius: var(--radius-md); background-color: var(--primary-light); display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                    <i class="bx bx-cog" style="font-size: 2rem; color: var(--primary);"></i>
                </div>
                <h3 style="font-size: 1.35rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.75rem;">Dashboard Admin</h3>
                <p style="color: var(--text-muted); line-height: 1.6; font-size: 0.95rem; margin-bottom: 2rem;">
                    Masuk ke panel kontrol loket untuk mengelola antrian, memanggil nomor antrian aktif, dan melihat statistik sederhana.
                </p>
            </div>
            <div class="d-flex align-center gap-2" style="font-weight: 600; color: var(--primary); font-size: 0.95rem;">
                <span>Buka Dashboard</span>
                <i class="bx bx-right-arrow-alt arrow-icon" style="font-size: 1.25rem;"></i>
            </div>
        </a>

        <!-- Card 3: Board Antrian -->
        <a href="{{ route('board') }}" class="card access-card card-board" style="text-decoration: none; display: flex; flex-direction: column; justify-content: space-between; border-radius: var(--radius-lg); padding: 2.25rem; height: 100%; margin-bottom: 0;">
            <div>
                <div style="width: 56px; height: 56px; border-radius: var(--radius-md); background-color: var(--warning-light); display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                    <i class="bx bx-desktop" style="font-size: 2rem; color: var(--warning);"></i>
                </div>
                <h3 style="font-size: 1.35rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.75rem;">Board Antrian</h3>
                <p style="color: var(--text-muted); line-height: 1.6; font-size: 0.95rem; margin-bottom: 2rem;">
                    Tampilkan layar monitor penuh untuk ruang tunggu untuk menyajikan status antrian secara real-time dan notifikasi suara.
                </p>
            </div>
            <div class="d-flex align-center gap-2" style="font-weight: 600; color: var(--warning); font-size: 0.95rem;">
                <span>Lihat Layar Board</span>
                <i class="bx bx-right-arrow-alt arrow-icon" style="font-size: 1.25rem;"></i>
            </div>
        </a>

    </div>
</div>
@endsection

@section('script-page')
@endsection