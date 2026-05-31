@extends('layouts.papan')

@section('content')
    <div class="d-flex align-center justify-between mt-4" style="width: 100%; max-width: 1200px; margin: 0 auto; padding: 1rem 2rem;">
        <h1>Papan Antrian Real-Time</h1>
        <div class="sse-status">
            <span class="sse-dot pulse" id="sse-status-dot"></span>
            <span id="sse-status-text">SSE Connected</span>
        </div>
    </div>
    
    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; flex: 1; min-height: 70vh;">
        <div class="card text-center" style="width: 100%; max-width: 600px; padding: 3rem; box-shadow: var(--shadow-lg);">
            <span style="font-size: 1.5rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); font-weight: 600;">Nomor Saat Ini</span>
            <h1 style="font-size: 8rem; font-weight: 800; color: var(--primary); margin: 1rem 0; line-height: 1;">A-001</h1>
            <span style="font-size: 2rem; font-weight: 500; color: var(--success);" id="active-guest-name">BUDI</span>
        </div>
    </div>
@endsection

@section('script-page')
@endsection
