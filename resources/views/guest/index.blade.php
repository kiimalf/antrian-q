@extends('layouts.guest')

@section('content')
<div style="max-width: 500px; margin: 3rem auto; padding: 0 1rem;">
    <div class="card" style="border-radius: var(--radius-lg); padding: 2.5rem; box-shadow: var(--shadow-lg); margin-bottom: 0;">
        <div class="text-center mb-4">
            <div style="width: 64px; height: 64px; border-radius: var(--radius-md); background-color: var(--success-light); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                <i class="bx bx-user-plus" style="font-size: 2.25rem; color: var(--success);"></i>
            </div>
            <h2 style="font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Ambil Nomor Antrian</h2>
            <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.5;">Masukkan nama Anda untuk mendaftar antrian baru dan mendapatkan tiket antrian.</p>
        </div>

        <form action="{{ route('guest.store') }}" method="POST" id="form-ambil-antrian">
            @csrf
            <div class="form-group mb-4">
                <label for="nama" class="form-label" style="font-weight: 600;">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Budi Santoso" required autocomplete="off" style="height: 48px;">
            </div>

            <button type="submit" class="btn btn-success w-100" style="padding: 0.85rem; font-weight: 600; font-size: 1rem;">
                <i class="bx bx-receipt" style="font-size: 1.2rem;"></i> Ambil Tiket Antrian
            </button>
        </form>
    </div>
</div>
@endsection

@section('script-page')
@endsection
