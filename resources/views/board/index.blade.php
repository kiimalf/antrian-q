@extends('layouts.board')

@section('title', 'Board Antrian Utama Real-Time')

@section('style-page')
<style>
    .board-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    
    .board-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        margin-bottom: 2rem;
    }
    
    .main-call-card {
        background: var(--bg-surface);
        border: 2px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 4rem 2rem;
        box-shadow: var(--shadow-lg);
        text-align: center;
        margin-bottom: 2.5rem;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }
    
    /* Elegant animated glowing frame when calling is active */
    .main-call-card.calling-active {
        border-color: var(--success);
        background: radial-gradient(circle at center, rgba(13, 148, 136, 0.04) 0%, var(--bg-surface) 100%);
        animation: card-flash 2.5s infinite ease-in-out;
    }
    
    @keyframes card-flash {
        0% { border-color: var(--success); box-shadow: 0 10px 30px rgba(13, 148, 136, 0.1); }
        50% { border-color: #3b82f6; box-shadow: 0 10px 40px rgba(59, 130, 246, 0.18); }
        100% { border-color: var(--success); box-shadow: 0 10px 30px rgba(13, 148, 136, 0.1); }
    }
    
    .board-number {
        font-size: 10rem;
        font-weight: 800;
        color: var(--primary);
        line-height: 1;
        margin: 1.5rem 0;
        letter-spacing: -3px;
        font-family: 'Outfit', sans-serif;
        transition: all 0.3s ease;
    }
    
    .main-call-card.calling-active .board-number {
        color: var(--success);
    }
    
    .history-section {
        margin-top: auto;
    }
    
    .history-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .history-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }
    
    .history-card {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 1.25rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }
    
    .history-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    
    .history-number {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--text-primary);
        font-family: 'Outfit', sans-serif;
    }
    
    .history-info {
        text-align: right;
    }
    
    .history-name {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.95rem;
    }
    
    .history-status {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 0.15rem;
    }
</style>
@endsection

@section('content')
<div class="board-container">
    
    <!-- Board Header -->
    <div class="board-header">
        <div class="d-flex align-center gap-3">
            <div style="width: 44px; height: 44px; border-radius: var(--radius-sm); background-color: var(--primary-light); display: flex; align-items: center; justify-content: center;">
                <i class="bx bx-desktop" style="font-size: 1.5rem; color: var(--primary);"></i>
            </div>
            <div>
                <h1 style="font-size: 1.35rem; font-weight: 800; color: var(--text-primary); line-height: 1.2;">Board Antrian Utama</h1>
                <span id="current-date" style="font-size: 0.8rem; color: var(--text-muted); font-weight: 500;">Minggu, 31 Mei 2026</span>
            </div>
        </div>
        
        <div class="d-flex align-center gap-3">
            <div class="date-time">
                <i class="bx bx-time" style="font-size: 1.1rem;"></i>
                <span id="current-time">00:00:00</span>
            </div>
            
            <div class="sse-status">
                <span class="sse-dot pulse" id="sse-status-dot"></span>
                <span id="sse-status-text">Menghubungkan...</span>
            </div>
        </div>
    </div>
    
    <!-- Main Calling Screen Card -->
    <div id="main-call-card" class="main-call-card {{ $current ? 'calling-active' : '' }}">
        <span style="font-size: 1.35rem; text-transform: uppercase; letter-spacing: 0.12em; color: var(--text-muted); font-weight: 700; display: inline-flex; align-items: center; gap: 0.5rem;">
            <i class="bx bx-bullseye" style="color: var(--success);"></i> Panggilan Aktif
        </span>
        
        <div class="board-number" id="board-number-display">
            {{ $current ? 'A-' . sprintf('%03d', $current->number) : 'A-000' }}
        </div>
        
        <span style="font-size: 2.25rem; font-weight: 700; color: var(--text-primary); transition: color 0.3s ease;" id="active-guest-name">
            {{ $current ? $current->name : 'Silakan Ambil Antrian' }}
        </span>
        
        <div id="calling-bell-icon" style="margin-top: 1.5rem; color: var(--success); font-size: 1.5rem; display: {{ $current ? 'block' : 'none' }};">
            <i class="bx bx-volume-full animate-bounce"></i> Sedang dipanggil ke Meja Layanan
        </div>
    </div>
    
    <!-- History of recent calls -->
    <div class="history-section">
        <h3 class="history-title">
            <i class="bx bx-history"></i> Panggilan Sebelumnya
        </h3>
        
        <div class="history-grid" id="history-grid-container">
            @forelse($history as $hist)
                <div class="history-card">
                    <div class="history-number">A-{{ sprintf('%03d', $hist->number) }}</div>
                    <div class="history-info">
                        <div class="history-name">{{ $hist->name }}</div>
                        <div class="history-status">
                            @if($hist->status == 'called')
                                <span class="badge badge-success" style="font-size: 0.65rem;">Dipanggil</span>
                            @elseif($hist->status == 'completed')
                                <span class="badge badge-success" style="font-size: 0.65rem; background-color: var(--primary-light); color: var(--primary);">Selesai</span>
                            @elseif($hist->status == 'late')
                                <span class="badge badge-danger" style="font-size: 0.65rem;">Terlewat</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: var(--text-muted); background: var(--bg-surface); border: 1px solid var(--border-color); border-radius: var(--radius-md);">
                    Belum ada panggilan sebelumnya.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@section('script-page')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const boardCard = document.getElementById('main-call-card');
        const boardNumberEl = document.getElementById('board-number-display');
        const boardNameEl = document.getElementById('active-guest-name');
        const bellIconEl = document.getElementById('calling-bell-icon');
        
        let lastPlayedQueueId = null;

        // Play dingdong.mp3 audio chime, with Web Audio API synthesizer fallback
        function playCallChime(callback) {
            try {
                const audio = new Audio('/audio/dingdong.mp3');
                
                // Execute callback (speech) once the chime audio ends
                audio.onended = function() {
                    if (callback) callback();
                };
                
                audio.play().catch(e => {
                    console.warn('Audio play blocked or failed, using synth fallback:', e);
                    playWebAudioChime();
                    if (callback) {
                        setTimeout(callback, 800);
                    }
                });
            } catch (e) {
                console.warn('Error playing audio file, using synth fallback:', e);
                playWebAudioChime();
                if (callback) {
                    setTimeout(callback, 800);
                }
            }
        }

        // Web Audio API synthesized chime fallback
        function playWebAudioChime() {
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
                console.warn('Synth Audio Context error: ', e);
            }
        }

        // Native Text-to-Speech Call announcer (Indonesian lang)
        function announceQueueIndonesian(number, name, onFinished) {
            if ('speechSynthesis' in window) {
                // Cancel any ongoing speaking to avoid overlapping
                window.speechSynthesis.cancel();

                // Format: A-001 -> prefix 'A', digits '0', '0', '1'
                const parts = number.split('-');
                const letter = parts[0] || 'A';
                const digits = (parts[1] || '000').split('');
                
                // Spell digits, replacing '0' with 'kosong' for clear speaking
                const spelledDigits = digits.map(d => d === '0' ? 'kosong' : d).join(', ');
                
                const message = `Nomor antrian, ${letter}, ${spelledDigits}. Atas nama, ${name}. Silakan menuju ke meja layanan.`;
                
                const utterance = new SpeechSynthesisUtterance(message);
                utterance.lang = 'id-ID';
                utterance.rate = 0.85; // Natural flow rate
                utterance.pitch = 1.0;
                
                // Prevent garbage collection bug in Chrome
                window._currentUtterance = utterance;

                if (onFinished) {
                    let isFinished = false;
                    const finishOnce = () => {
                        if (!isFinished) {
                            isFinished = true;
                            onFinished();
                        }
                    };
                    utterance.onend = finishOnce;
                    utterance.onerror = finishOnce;
                    
                    // Fallback timeout in case speech API hangs (20 seconds max)
                    setTimeout(finishOnce, 20000);
                }
                
                // Find Indonesian voice if possible
                const voices = window.speechSynthesis.getVoices();
                const idVoice = voices.find(voice => voice.lang.includes('id') || voice.lang.includes('ID'));
                if (idVoice) {
                    utterance.voice = idVoice;
                }
                
                // Play chime first, then voice upon complete playback of the chime
                playCallChime(() => {
                    window.speechSynthesis.speak(utterance);
                });
            } else {
                // fallback chime only
                playCallChime(() => {
                    if (onFinished) setTimeout(onFinished, 2000);
                });
            }
        }

        // Handle updates and trigger voice announcement
        function handleCallUpdate(queueItem, isRecall = false) {
            if (!queueItem) return;
            
            // Format queue number
            const formattedNum = 'A-' + String(queueItem.number).padStart(3, '0');
            
            // Update UI elements immediately
            boardNumberEl.textContent = formattedNum;
            boardNameEl.textContent = queueItem.name;
            bellIconEl.style.display = 'block';
            boardCard.classList.add('calling-active');
            
            // Function to perform reload
            const performReload = () => {
                window.location.reload();
            };
            
            // Announce voice if it's a new call or explicitly a recall
            if (isRecall || lastPlayedQueueId !== queueItem.id) {
                lastPlayedQueueId = queueItem.id;
                announceQueueIndonesian(formattedNum, queueItem.name, performReload);
            } else {
                setTimeout(performReload, 3000);
            }
        }

        // SSE Connection
        let sse = null;
        
        function connectBoardSSE() {
            window.updateSSEStatus('connecting');
            
            sse = new EventSource('/sse/antrian');
            
            sse.onopen = function() {
                window.updateSSEStatus('connected');
                console.log("Board SSE Connected.");
            };
            
            sse.onerror = function() {
                window.updateSSEStatus('disconnected');
                console.warn("Board SSE connection lost. Reconnecting in 4 seconds...");
                sse.close();
                setTimeout(connectBoardSSE, 4000);
            };
            
            // Listen to 'queue-update' event
            sse.addEventListener('queue-update', function(event) {
                try {
                    const data = JSON.parse(event.data);
                    
                    if (data) {
                        // Call event
                        if (data.action === 'call') {
                            handleCallUpdate(data.antrian, false);
                        } 
                        // Recall event
                        else if (data.action === 'recall') {
                            handleCallUpdate(data.antrian, true);
                        } 
                        // Other updates (store, status changes), reload to keep list fresh
                        else {
                            window.location.reload();
                        }
                    }
                } catch(e) {
                    console.error("Error processing Board SSE message:", e);
                }
            });
        }
        
        connectBoardSSE();
        
        // Ensure voice list is pre-loaded on chrome
        if ('speechSynthesis' in window && window.speechSynthesis.onvoiceschanged !== undefined) {
            window.speechSynthesis.onvoiceschanged = () => {};
        }
    });
</script>
@endsection
