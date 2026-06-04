@extends('layouts.guest')

@section('title', 'Tiket Antrian #' . sprintf('%03d', $antrian->number) . ' - ' . $antrian->name)

@section('style-page')
<style>
    .ticket-container {
        max-width: 450px;
        margin: 2.5rem auto;
        padding: 0 1rem;
    }
    
    /* Elegant Ticket stub design */
    .ticket-card {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        position: relative;
        overflow: visible;
        box-shadow: var(--shadow-lg);
        transition: var(--transition);
    }
    
    .ticket-card::before,
    .ticket-card::after {
        content: '';
        position: absolute;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: var(--bg-base);
        border: 1px solid var(--border-color);
        z-index: 5;
    }

    /* Half circle cut-outs on the borders between header and body */
    .ticket-card::before {
        top: 98px;
        left: -13px;
        clip-path: polygon(50% 0%, 100% 0%, 100% 100%, 50% 100%);
    }

    .ticket-card::after {
        top: 98px;
        right: -13px;
        clip-path: polygon(0% 0%, 50% 0%, 50% 100%, 0% 100%);
    }
    
    .ticket-header {
        padding: 1.75rem 2rem;
        border-bottom: 2px dashed var(--border-color);
        position: relative;
        text-align: left;
    }
    
    .ticket-body {
        padding: 2.5rem 2rem;
        text-align: center;
    }
    
    .ticket-footer {
        padding: 1.5rem 2rem 2rem;
        background-color: var(--primary-light);
        border-top: 1px solid var(--border-color);
        border-bottom-left-radius: var(--radius-lg);
        border-bottom-right-radius: var(--radius-lg);
    }
    
    .ticket-number {
        font-size: 5rem;
        font-weight: 800;
        letter-spacing: -2px;
        color: var(--primary);
        line-height: 1;
        margin: 0.75rem 0;
        font-family: 'Outfit', sans-serif;
    }
    
    /* Aesthetic Dummy Barcode */
    .barcode-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 2px;
        margin: 1.75rem auto 0.5rem;
        height: 38px;
        opacity: 0.8;
    }
    
    .barcode-line {
        height: 100%;
        background-color: var(--text-primary);
        border-radius: 1px;
        transition: var(--transition);
    }
    
    /* Highlight pulse animation for when called */
    @keyframes pulse-call {
        0% {
            box-shadow: var(--shadow-lg);
            transform: scale(1);
            border-color: var(--success);
        }
        50% {
            box-shadow: 0 0 25px rgba(13, 148, 136, 0.45);
            transform: scale(1.02);
            border-color: var(--success);
        }
        100% {
            box-shadow: var(--shadow-lg);
            transform: scale(1);
            border-color: var(--success);
        }
    }
    
    .status-called-active {
        animation: pulse-call 2s infinite ease-in-out;
        border-color: var(--success) !important;
    }

    /* Print styling rules */
    @media print {
        body {
            background: #ffffff !important;
            color: #000000 !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .container-scroller, .navbar, .footer, .btn, .sse-status, .no-print {
            display: none !important;
        }
        .ticket-container {
            margin: 0 auto !important;
            padding: 0 !important;
            max-width: 320px !important;
            width: 100% !important;
            box-shadow: none !important;
        }
        .ticket-card {
            border: 1px solid #000 !important;
            box-shadow: none !important;
            transform: none !important;
            background: #fff !important;
            border-radius: 0 !important;
        }
        .ticket-card::before, .ticket-card::after {
            display: none !important;
        }
        .ticket-header {
            padding: 1.25rem !important;
            border-bottom: 1px dashed #000000 !important;
        }
        .ticket-body {
            padding: 1.5rem 1.25rem !important;
        }
        .ticket-footer {
            display: none !important;
        }
        .ticket-number {
            font-size: 4.5rem !important;
            color: #000000 !important;
        }
        .barcode-line {
            background-color: #000000 !important;
        }
    }
</style>
@endsection

@section('content')
<div class="ticket-container">
    <div id="ticket-card" class="ticket-card {{ $antrian->status == 'called' ? 'status-called-active' : '' }}">
        
        <!-- Header Section -->
        <div class="ticket-header">
            <div class="d-flex justify-between align-center">
                <div class="d-flex align-center gap-2">
                    <i class="bx bx-receipt" style="font-size: 1.35rem; color: var(--success);"></i>
                    <span style="font-weight: 700; color: var(--text-primary); font-size: 0.9rem; letter-spacing: 0.05em; text-transform: uppercase;">
                        Antrian Digital
                    </span>
                </div>
                <div id="status-badge-container">
                    @if($antrian->status == 'waiting')
                        <span class="badge badge-warning" id="ticket-status-badge">
                            <i class="bx bx-time-five" style="margin-right: 0.25rem;"></i> Menunggu
                        </span>
                    @elseif($antrian->status == 'called')
                        <span class="badge badge-success" id="ticket-status-badge">
                            <i class="bx bx-volume-full" style="margin-right: 0.25rem;"></i> Dipanggil
                        </span>
                    @elseif($antrian->status == 'late')
                        <span class="badge badge-danger" id="ticket-status-badge">
                            <i class="bx bx-refresh" style="margin-right: 0.25rem;"></i> Terlewat
                        </span>
                    @elseif($antrian->status == 'completed')
                        <span class="badge badge-success" id="ticket-status-badge" style="background-color: var(--primary-light); color: var(--primary);">
                            <i class="bx bx-check-circle" style="margin-right: 0.25rem;"></i> Selesai
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="d-flex justify-between align-center mt-3" style="font-size: 0.85rem; color: var(--text-muted);">
                <span>No. Reg: <strong style="color: var(--text-primary);">#{{ $antrian->id }}</strong></span>
                <span>{{ $antrian->created_at->format('d M Y - H:i') }}</span>
            </div>
        </div>

        <!-- Body Section -->
        <div class="ticket-body">
            <span class="text-muted" style="font-size: 0.85rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase;">Nomor Antrian</span>
            
            <div class="ticket-number" id="ticket-number-display">A-{{ sprintf('%03d', $antrian->number) }}</div>
            
            <h4 style="font-weight: 700; color: var(--text-primary); margin-top: 0.75rem; font-size: 1.35rem;" id="ticket-guest-name">
                {{ $antrian->name }}
            </h4>
            
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.75rem; line-height: 1.6; min-height: 54px;" id="ticket-status-message">
                @if($antrian->status == 'waiting')
                    Harap menunggu nomor Anda dipanggil pada layar board informasi utama.
                @elseif($antrian->status == 'called')
                    Nomor Anda sedang dipanggil! Silakan segera menuju ke meja layanan.
                @elseif($antrian->status == 'late')
                    Nomor Anda telah terlewat. Silakan temui petugas loket untuk penanganan lebih lanjut.
                @elseif($antrian->status == 'completed')
                    Layanan selesai. Terima kasih telah menggunakan jasa layanan kami.
                @endif
            </p>

            <!-- Aesthetic dummy barcode lines -->
            <div class="barcode-container" title="Barcode Antrian">
                <div class="barcode-line" style="width: 2px;"></div>
                <div class="barcode-line" style="width: 1px;"></div>
                <div class="barcode-line" style="width: 3px;"></div>
                <div class="barcode-line" style="width: 4px;"></div>
                <div class="barcode-line" style="width: 1px;"></div>
                <div class="barcode-line" style="width: 2px;"></div>
                <div class="barcode-line" style="width: 5px;"></div>
                <div class="barcode-line" style="width: 1px;"></div>
                <div class="barcode-line" style="width: 2px;"></div>
                <div class="barcode-line" style="width: 4px;"></div>
                <div class="barcode-line" style="width: 2px;"></div>
                <div class="barcode-line" style="width: 1px;"></div>
                <div class="barcode-line" style="width: 3px;"></div>
                <div class="barcode-line" style="width: 1px;"></div>
                <div class="barcode-line" style="width: 4px;"></div>
                <div class="barcode-line" style="width: 5px;"></div>
                <div class="barcode-line" style="width: 2px;"></div>
                <div class="barcode-line" style="width: 1px;"></div>
                <div class="barcode-line" style="width: 3px;"></div>
                <div class="barcode-line" style="width: 1px;"></div>
                <div class="barcode-line" style="width: 2px;"></div>
            </div>
            <span style="font-family: monospace; font-size: 0.75rem; color: var(--text-muted); letter-spacing: 2px;">
                *{{ sprintf('%08d', $antrian->id) }}*
            </span>
        </div>

        <!-- Footer / Action Area -->
        <div class="ticket-footer no-print">
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <button onclick="window.print()" class="btn btn-primary w-100" style="padding: 0.8rem; font-weight: 600;">
                    <i class="bx bx-printer" style="font-size: 1.25rem;"></i> Cetak Tiket
                </button>
                <a href="{{ route('guest') }}" class="btn btn-outline w-100" style="padding: 0.8rem; font-weight: 600;">
                    <i class="bx bx-user-plus" style="font-size: 1.25rem;"></i> Ambil Antrian Baru
                </a>
            </div>
            
            <div class="text-center mt-4">
                <div class="sse-status" style="justify-content: center; background-color: rgba(255,255,255,0.6);">
                    <span class="sse-dot pulse" id="sse-status-dot"></span>
                    <span id="sse-status-text">Menghubungkan update...</span>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection

@section('script-page')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ticketId = {{ $antrian->id }};
        const ticketCard = document.getElementById('ticket-card');
        const badgeContainer = document.getElementById('status-badge-container');
        const statusMessageEl = document.getElementById('ticket-status-message');
        
        let currentStatus = '{{ $antrian->status }}';

        // Custom chime sound using Web Audio API
        function playCallChime() {
            try {
                const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                
                // Tone 1: E5
                const osc1 = audioCtx.createOscillator();
                const gain1 = audioCtx.createGain();
                osc1.type = 'sine';
                osc1.frequency.setValueAtTime(659.25, audioCtx.currentTime); // E5
                gain1.gain.setValueAtTime(0.08, audioCtx.currentTime);
                gain1.gain.exponentialRampToValueAtTime(0.0001, audioCtx.currentTime + 0.5);
                osc1.connect(gain1);
                gain1.connect(audioCtx.destination);
                osc1.start();
                osc1.stop(audioCtx.currentTime + 0.5);
                
                // Tone 2: A5 (played slightly later)
                setTimeout(() => {
                    const osc2 = audioCtx.createOscillator();
                    const gain2 = audioCtx.createGain();
                    osc2.type = 'sine';
                    osc2.frequency.setValueAtTime(880.00, audioCtx.currentTime); // A5
                    gain2.gain.setValueAtTime(0.08, audioCtx.currentTime);
                    gain2.gain.exponentialRampToValueAtTime(0.0001, audioCtx.currentTime + 0.6);
                    osc2.connect(gain2);
                    gain2.connect(audioCtx.destination);
                    osc2.start();
                    osc2.stop(audioCtx.currentTime + 0.6);
                }, 140);
            } catch (e) {
                console.warn('Audio Context error: ', e);
            }
        }

        // Function to update the page elements dynamically when status changes
        function handleStatusChange(newStatus) {
            if (newStatus === currentStatus) return;
            
            currentStatus = newStatus;
            
            // Trigger audio and animation highlight if called
            if (newStatus === 'called') {
                playCallChime();
                ticketCard.classList.add('status-called-active');
            } else {
                ticketCard.classList.remove('status-called-active');
            }
            
            // Update the status badge
            let badgeHtml = '';
            let messageText = '';
            
            switch(newStatus) {
                case 'waiting':
                    badgeHtml = `
                        <span class="badge badge-warning" id="ticket-status-badge">
                            <i class="bx bx-time-five" style="margin-right: 0.25rem;"></i> Menunggu
                        </span>`;
                    messageText = 'Harap menunggu nomor Anda dipanggil pada layar board informasi utama.';
                    break;
                case 'called':
                    badgeHtml = `
                        <span class="badge badge-success" id="ticket-status-badge">
                            <i class="bx bx-volume-full" style="margin-right: 0.25rem;"></i> Dipanggil
                        </span>`;
                    messageText = 'Nomor Anda sedang dipanggil! Silakan segera menuju ke meja layanan.';
                    break;
                case 'late':
                    badgeHtml = `
                        <span class="badge badge-danger" id="ticket-status-badge">
                            <i class="bx bx-refresh" style="margin-right: 0.25rem;"></i> Terlewat
                        </span>`;
                    messageText = 'Nomor Anda telah terlewat. Silakan temui petugas loket untuk penanganan lebih lanjut.';
                    break;
                case 'completed':
                    badgeHtml = `
                        <span class="badge badge-success" id="ticket-status-badge" style="background-color: var(--primary-light); color: var(--primary);">
                            <i class="bx bx-check-circle" style="margin-right: 0.25rem;"></i> Selesai
                        </span>`;
                    messageText = 'Layanan selesai. Terima kasih telah menggunakan jasa layanan kami.';
                    break;
            }
            
            badgeContainer.innerHTML = badgeHtml;
            statusMessageEl.textContent = messageText;
            
            // Visual transition glow on message
            statusMessageEl.style.transition = 'text-shadow 0.3s ease, color 0.3s ease';
            statusMessageEl.style.color = 'var(--text-primary)';
            statusMessageEl.style.textShadow = '0 0 8px rgba(13, 148, 136, 0.2)';
            setTimeout(() => {
                statusMessageEl.style.color = 'var(--text-muted)';
                statusMessageEl.style.textShadow = 'none';
            }, 3000);
        }

        // Establish Server-Sent Events connection
        let sseSource = null;
        
        function initSSE() {
            window.updateSSEStatus('connecting');
            
            // Connect to sse/antrian endpoint
            sseSource = new EventSourceEventSource('/sse/antrian');
            
            sseSource.onopen = function() {
                window.updateSSEStatus('connected');
                console.log("SSE connected successfully.");
            };
            
            sseSource.onerror = function() {
                window.updateSSEStatus('disconnected');
                console.warn("SSE connection lost. Retrying in 5 seconds...");
                sseSource.close();
                setTimeout(initSSE, 5000);
            };
            
            // Listen to 'queue-update' event
            sseSource.addEventListener('queue-update', function(event) {
                try {
                    const data = JSON.parse(event.data);
                    
                    // Match event payload structure (e.g. {action: 'call', antrian: {...}})
                    if (data && data.antrian && data.antrian.id == ticketId) {
                        handleStatusChange(data.antrian.status);
                    } 
                    // Match single item update directly
                    else if (data && data.id == ticketId) {
                        handleStatusChange(data.status);
                    }
                } catch(e) {
                    console.error("Error processing SSE message:", e);
                }
            });
        }

        // Start real-time SSE listener
        initSSE();
        
        // Polling Fallback (runs every 8 seconds to check status in case SSE is not supported/failing)
        setInterval(function() {
            fetch(`/guest/tiket/${ticketId}/status`)
                .then(res => {
                    if (res.ok) return res.json();
                    throw new Error('Not OK');
                })
                .then(data => {
                    if (data && data.status) {
                        handleStatusChange(data.status);
                    }
                })
                .catch(err => {
                    console.debug("Polling status check skipped (endpoint might not be active yet):", err);
                });
        }, 8000);
    });
</script>
@endsection
