<style>
    :root {
        /* Colors: Cerah, Netral, Simpel */
        --bg-base: #f8fafc;        /* Slate 50 - Background utama */
        --bg-surface: #ffffff;     /* Putih bersih - Card & Panel */
        --border-color: #e2e8f0;   /* Slate 200 - Border halus */
        --text-primary: #0f172a;   /* Slate 900 - Teks utama */
        --text-muted: #64748b;     /* Slate 500 - Teks sekunder */
        
        /* Accents & States */
        --primary: #1e293b;        /* Slate 800 - Warna dominan netral */
        --primary-hover: #0f172a;  /* Slate 900 */
        --primary-light: #f1f5f9;  /* Slate 100 - Hover bg */
        
        --success: #0d9488;        /* Teal 600 - Sukses/Hadir */
        --success-light: #ccfbf1;  /* Teal 100 */
        
        --warning: #d97706;        /* Amber 600 - Menunggu/Terlambat */
        --warning-light: #fef3c7;  /* Amber 100 */
        
        --danger: #e11d48;         /* Rose 600 - Batal/Hapus */
        --danger-light: #ffe4e6;   /* Rose 100 */
        
        /* Typography & Layout spacing */
        --font-sans: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.03), 0 4px 6px -4px rgba(0, 0, 0, 0.03);
        
        --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Reset & Base Styles */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: var(--font-sans);
        background-color: var(--bg-base);
        color: var(--text-primary);
        line-height: 1.5;
        overflow-x: hidden;
        -webkit-font-smoothing: antialiased;
    }

    /* Layout Scroller & Wrapper */
    .container-scroller {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .page-body-wrapper {
        display: flex;
        flex: 1;
        width: 100%;
        margin-top: 70px; /* Sesuai tinggi navbar */
    }

    /* Navbar */
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 70px;
        background-color: var(--bg-surface);
        border-bottom: 1px solid var(--border-color);
        padding: 0 2rem;
        z-index: 1030;
        box-shadow: var(--shadow-sm);
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-decoration: none;
        color: var(--text-primary);
        font-weight: 700;
        font-size: 1.25rem;
    }

    .navbar-brand i {
        font-size: 1.5rem;
        color: var(--primary);
    }

    .navbar-menu {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    /* Status Indicator (SSE) */
    .sse-status {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0.85rem;
        border-radius: var(--radius-sm);
        background-color: var(--primary-light);
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--text-muted);
        border: 1px solid var(--border-color);
    }

    .sse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: var(--success);
        position: relative;
    }

    .sse-dot.pulse::after {
        content: '';
        position: absolute;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: var(--success);
        animation: pulse-dot 1.5s infinite ease-in-out;
    }

    @keyframes pulse-dot {
        0% { transform: scale(1); opacity: 1; }
        100% { transform: scale(3.5); opacity: 0; }
    }

    /* Sidebar */
    .sidebar {
        width: 260px;
        background-color: var(--bg-surface);
        border-right: 1px solid var(--border-color);
        padding: 2rem 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        height: calc(100vh - 70px);
        position: fixed;
        left: 0;
        overflow-y: auto;
        z-index: 1000;
        transition: var(--transition);
    }

    .nav-item {
        list-style: none;
        width: 100%;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        padding: 0.85rem 1rem;
        color: var(--text-muted);
        text-decoration: none;
        border-radius: var(--radius-sm);
        font-weight: 500;
        font-size: 0.95rem;
        transition: var(--transition);
    }

    .nav-link i {
        font-size: 1.25rem;
        transition: var(--transition);
    }

    .nav-link:hover {
        background-color: var(--primary-light);
        color: var(--text-primary);
    }

    .nav-item.active .nav-link {
        background-color: var(--primary);
        color: var(--bg-surface);
    }

    .nav-item.active .nav-link i {
        color: var(--bg-surface);
    }

    /* Main Panel & Wrapper */
    .main-panel {
        flex: 1;
        margin-left: 260px; /* Sesuai lebar sidebar */
        display: flex;
        flex-direction: column;
        min-height: calc(100vh - 70px);
        transition: var(--transition);
    }

    .content-wrapper {
        flex: 1;
        padding: 2rem;
        background-color: var(--bg-base);
    }

    /* Footer */
    .footer {
        background-color: var(--bg-surface);
        border-top: 1px solid var(--border-color);
        padding: 1.5rem 2rem;
        font-size: 0.85rem;
        color: var(--text-muted);
        text-align: center;
    }

    /* Common Components UI */
    .card {
        background-color: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        margin-bottom: 1.5rem;
        transition: var(--transition);
    }

    .card:hover {
        box-shadow: var(--shadow-md);
    }

    .card-title {
        font-size: 1.15rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-title i {
        color: var(--text-muted);
    }

    /* Form Inputs */
    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        font-family: var(--font-sans);
        color: var(--text-primary);
        background-color: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-sm);
        outline: none;
        transition: var(--transition);
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(30, 41, 59, 0.1);
    }

    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-size: 0.95rem;
        font-weight: 500;
        font-family: var(--font-sans);
        border-radius: var(--radius-sm);
        border: 1px solid transparent;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
    }

    .btn-primary {
        background-color: var(--primary);
        color: var(--bg-surface);
    }

    .btn-primary:hover {
        background-color: var(--primary-hover);
    }

    .btn-outline {
        background-color: transparent;
        border-color: var(--border-color);
        color: var(--text-primary);
    }

    .btn-outline:hover {
        background-color: var(--primary-light);
        border-color: var(--border-color);
    }

    .btn-success {
        background-color: var(--success);
        color: var(--bg-surface);
    }

    .btn-success:hover {
        opacity: 0.9;
    }

    .btn-warning {
        background-color: var(--warning);
        color: var(--bg-surface);
    }

    .btn-warning:hover {
        opacity: 0.9;
    }

    .btn-danger {
        background-color: var(--danger);
        color: var(--bg-surface);
    }

    .btn-danger:hover {
        opacity: 0.9;
    }

    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 100px;
    }

    .badge-success {
        background-color: var(--success-light);
        color: var(--success);
    }

    .badge-warning {
        background-color: var(--warning-light);
        color: var(--warning);
    }

    .badge-danger {
        background-color: var(--danger-light);
        color: var(--danger);
    }

    /* Tables */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .table th {
        padding: 1rem;
        border-bottom: 2px solid var(--border-color);
        font-weight: 600;
        color: var(--text-muted);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .table td {
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.95rem;
        vertical-align: middle;
    }

    .table tr:hover td {
        background-color: var(--primary-light);
    }

    /* Utilities */
    .text-center { text-align: center; }
    .w-100 { width: 100%; }
    .mt-4 { margin-top: 1.5rem; }
    .mb-4 { margin-bottom: 1.5rem; }
    .d-flex { display: flex; }
    .align-center { align-items: center; }
    .justify-between { justify-content: space-between; }
    .gap-2 { gap: 0.5rem; }
    .gap-3 { gap: 1rem; }

    /* Responsive adjustments */
    @media (max-width: 991.98px) {
        .sidebar {
            transform: translateX(-100%);
            position: fixed;
        }
        .main-panel {
            margin-left: 0;
        }
        .sidebar.active {
            transform: translateX(0);
        }
    }
</style>
