@extends('layouts.admin')

@section('title', 'Dashboard Admin - Kelola Antrian')

@section('style-page')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        padding: 1.5rem;
        border-radius: var(--radius-md);
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        display: flex;
        align-items: center;
        gap: 1.25rem;
        transition: var(--transition);
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .stat-info {
        display: flex;
        flex-direction: column;
    }
    
    .stat-label {
        font-size: 0.85rem;
        color: var(--text-muted);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1.2;
        margin-top: 0.25rem;
    }

    /* Accent colors for stats */
    .icon-total { background-color: var(--primary-light); color: var(--primary); }
    .icon-waiting { background-color: var(--warning-light); color: var(--warning); }
    .icon-late { background-color: var(--danger-light); color: var(--danger); }
    .icon-completed { background-color: var(--success-light); color: var(--success); }
    
    /* Layout split */
    .dashboard-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
    }
    
    @media (max-width: 991.98px) {
        .dashboard-layout {
            grid-template-columns: 1fr;
        }
    }
    
    /* Calling Screen styling */
    .calling-card {
        text-align: center;
        padding: 3rem 2rem;
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        margin-bottom: 1.5rem;
        position: relative;
        transition: var(--transition);
    }
    
    .calling-card.active {
        border-color: var(--success);
        box-shadow: 0 10px 25px -5px rgba(13, 148, 136, 0.08);
    }
    
    .calling-number {
        font-size: 6.5rem;
        font-weight: 800;
        color: var(--primary);
        line-height: 1;
        margin: 1.5rem 0;
        font-family: 'Outfit', sans-serif;
        letter-spacing: -2px;
    }
    
    .calling-card.active .calling-number {
        color: var(--success);
    }
    
    .calling-actions {
        display: flex;
        justify-content: center;
        gap: 0.75rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }
    
    /* List items styling */
    .queue-list-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-color);
        transition: var(--transition);
    }
    
    .queue-list-item:last-child {
        border-bottom: none;
    }
    
    /* Activity Feed styling */
    .activity-feed {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        max-height: 380px;
        overflow-y: auto;
        padding-right: 0.5rem;
    }
    
    .activity-item {
        display: flex;
        gap: 0.75rem;
        font-size: 0.9rem;
        align-items: flex-start;
    }
    
    .activity-time {
        font-family: monospace;
        font-weight: 700;
        color: var(--text-muted);
        background-color: var(--primary-light);
        padding: 0.15rem 0.4rem;
        border-radius: 4px;
        font-size: 0.8rem;
    }
    
    .activity-desc {
        color: var(--text-primary);
        line-height: 1.4;
    }
    
    .activity-status-badge {
        font-size: 0.7rem;
        padding: 0.1rem 0.4rem;
        border-radius: 4px;
        font-weight: 600;
        margin-left: 0.35rem;
        text-transform: uppercase;
        display: inline-block;
    }
</style>
@endsection

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 1rem 0;">

    <!-- Alerts and Messages -->
    @if(session('success'))
        <div style="background-color: var(--success-light); color: var(--success); padding: 1rem 1.25rem; border-radius: var(--radius-md); border: 1px solid rgba(13, 148, 136, 0.2); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; font-weight: 500; box-shadow: var(--shadow-sm);">
            <i class="bx bx-check-circle" style="font-size: 1.35rem;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('info'))
        <div style="background-color: var(--primary-light); color: var(--text-primary); padding: 1rem 1.25rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; font-weight: 500; box-shadow: var(--shadow-sm);">
            <i class="bx bx-info-circle" style="font-size: 1.35rem; color: var(--text-muted);"></i>
            <span>{{ session('info') }}</span>
        </div>
    @endif

    <!-- Page Header -->
    <div class="d-flex justify-between align-center mb-4">
        <div>
            <h1 style="font-weight: 800; color: var(--text-primary); font-size: 1.75rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="bx bx-cog" style="color: var(--primary);"></i> Panel Loket Admin
            </h1>
            <p style="color: var(--text-muted); font-size: 0.95rem;">Kelola panggilan antrian dan lihat status antrian secara real-time.</p>
        </div>
        <div class="sse-status">
            <span class="sse-dot pulse" id="sse-status-dot"></span>
            <span id="sse-status-text">Menghubungkan update...</span>
        </div>
    </div>

    <!-- 1. Statistik Ringkas -->
    <div class="stats-grid">
        <!-- Total Hari Ini -->
        <div class="stat-card">
            <div class="stat-icon icon-total">
                <i class="bx bx-group"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total Hari Ini</span>
                <span class="stat-value" id="stat-total">{{ $total }}</span>
            </div>
        </div>

        <!-- Menunggu -->
        <div class="stat-card">
            <div class="stat-icon icon-waiting">
                <i class="bx bx-time"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Menunggu</span>
                <span class="stat-value" id="stat-waiting">{{ $waiting }}</span>
            </div>
        </div>

        <!-- Terlambat -->
        <div class="stat-card">
            <div class="stat-icon icon-late">
                <i class="bx bx-user-x"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Terlambat</span>
                <span class="stat-value" id="stat-late">{{ $late }}</span>
            </div>
        </div>

        <!-- Selesai -->
        <div class="stat-card">
            <div class="stat-icon icon-completed">
                <i class="bx bx-check-double"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Selesai</span>
                <span class="stat-value" id="stat-completed">{{ $completed }}</span>
            </div>
        </div>
    </div>

    <!-- Main Section Split -->
    <div class="dashboard-layout">
        
        <!-- Left Side: Calling Panel -->
        <div>
            <!-- 2. Nomor Sedang Dipanggil -->
            <div class="calling-card {{ $current ? 'active' : '' }}" id="calling-card-container">
                <h3 style="font-weight: 600; color: var(--text-muted); font-size: 1rem; text-transform: uppercase; letter-spacing: 0.08em; display: inline-flex; align-items: center; gap: 0.5rem; justify-content: center;">
                    <i class="bx bx-megaphone" style="font-size: 1.25rem;"></i> Nomor Sedang Dipanggil
                </h3>
                
                @if($current)
                    <div class="calling-number" id="calling-number-display">A-{{ sprintf('%03d', $current->number) }}</div>
                    <div style="font-size: 2rem; font-weight: 700; color: var(--text-primary);" id="calling-name-display">
                        {{ $current->name }}
                    </div>
                    
                    <div class="calling-actions">
                        <!-- Panggil Ulang -->
                        <form action="{{ route('admin.recall', $current->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-warning" style="padding: 0.8rem 1.5rem; font-weight: 600; border-radius: var(--radius-sm);">
                                <i class="bx bx-volume-full" style="font-size: 1.2rem;"></i> Panggil Ulang
                            </button>
                        </form>
                        
                        <!-- Selesai -->
                        <form action="{{ route('admin.complete', $current->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-success" style="padding: 0.8rem 1.5rem; font-weight: 600; border-radius: var(--radius-sm);">
                                <i class="bx bx-check-circle" style="font-size: 1.2rem;"></i> Selesai
                            </button>
                        </form>
                        
                        <!-- Terlewat -->
                        <form action="{{ route('admin.late', $current->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-danger" style="padding: 0.8rem 1.5rem; font-weight: 600; border-radius: var(--radius-sm);">
                                <i class="bx bx-x-circle" style="font-size: 1.2rem;"></i> Terlewat
                            </button>
                        </form>
                    </div>
                @else
                    <div class="calling-number" style="color: var(--text-muted); opacity: 0.3;">A-000</div>
                    <div style="font-size: 1.35rem; font-weight: 600; color: var(--text-muted); margin-bottom: 1.5rem;">
                        Tidak Ada Antrian Aktif
                    </div>
                @endif
                
                <!-- Action Button: Panggil Selanjutnya -->
                <div style="margin-top: 2.5rem; border-top: 1px solid var(--border-color); padding-top: 2rem; display: flex; justify-content: center;">
                    <form action="{{ route('admin.call-next') }}" method="POST" style="width: 100%; max-width: 360px;">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100" style="padding: 1rem; font-weight: 700; font-size: 1.05rem; border-radius: var(--radius-md); box-shadow: var(--shadow-sm);">
                            Panggil Antrian Berikutnya <i class="bx bx-right-arrow-alt" style="font-size: 1.4rem; margin-left: 0.25rem;"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Side: Sidebar Panels (Queue list and Activity log) -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            
            <!-- 3. Queue Selanjutnya -->
            <div class="card" style="margin-bottom: 0;">
                <h3 class="card-title">
                    <i class="bx bx-list-ol" style="color: var(--warning);"></i> Antrian Berikutnya
                </h3>
                
                <div style="margin-top: 0.5rem; display: flex; flex-direction: column;">
                    @forelse($next as $index => $item)
                        <div class="queue-list-item">
                            <div class="d-flex align-center gap-2">
                                <span style="font-weight: 700; color: var(--text-muted); font-size: 0.85rem; width: 20px;">{{ $index + 1 }}.</span>
                                <div>
                                    <div style="font-weight: 700; color: var(--text-primary); font-size: 0.95rem; line-height: 1.2;">
                                        A-{{ sprintf('%03d', $item->number) }}
                                    </div>
                                    <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.15rem;">
                                        {{ $item->name }}
                                    </div>
                                </div>
                            </div>
                            <span class="badge badge-warning" style="font-size: 0.65rem; font-weight: 700; padding: 0.15rem 0.5rem;">
                                waiting
                            </span>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 2rem 1rem; color: var(--text-muted); font-size: 0.9rem;">
                            <i class="bx bx-select-multiple" style="font-size: 2.25rem; opacity: 0.25; margin-bottom: 0.5rem; display: block;"></i>
                            Tidak ada antrian menunggu
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- 4. Aktivitas Terakhir -->
            <div class="card" style="margin-bottom: 0;">
                <h3 class="card-title">
                    <i class="bx bx-history" style="color: var(--primary);"></i> Aktivitas Terakhir
                </h3>
                
                <div class="activity-feed" style="margin-top: 0.5rem;">
                    @forelse($activities as $activity)
                        <div class="activity-item">
                            <span class="activity-time">{{ $activity->updated_at->format('H:i') }}</span>
                            <div class="activity-desc">
                                Nomor <strong>A-{{ sprintf('%03d', $activity->number) }}</strong> ({{ $activity->name }}) 
                                
                                @if($activity->status == 'called')
                                    <span class="activity-status-badge badge-success">dipanggil</span>
                                @elseif($activity->status == 'completed')
                                    <span class="activity-status-badge" style="background-color: var(--primary-light); color: var(--primary);">selesai</span>
                                @elseif($activity->status == 'late')
                                    <span class="activity-status-badge badge-danger">terlewat</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 2rem 1rem; color: var(--text-muted); font-size: 0.9rem;">
                            Belum ada aktivitas hari ini
                        </div>
                    @endforelse
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection

@section('script-page')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let sseSource = null;
        
        function connectDashboardSSE() {
            window.updateSSEStatus('connecting');
            
            // Connect to /sse/antrian
            sseSource = new EventSource('/sse/antrian');
            
            sseSource.onopen = function() {
                window.updateSSEStatus('connected');
                console.log("Dashboard SSE Connected.");
            };
            
            sseSource.onerror = function() {
                window.updateSSEStatus('disconnected');
                console.warn("Dashboard SSE connection failed. Re-trying in 4 seconds...");
                sseSource.close();
                setTimeout(connectDashboardSSE, 4000);
            };
            
            // Listen to 'queue-update' event
            sseSource.addEventListener('queue-update', function(event) {
                console.log("SSE queue-update received: ", event.data);
                // We reload the page to refresh the statistics, list, and activities instantly
                window.location.reload();
            });
        }
        
        // Start connection
        // connectDashboardSSE();
    });
</script>
@endsection
