<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Global helper for managing SSE status in UI
        window.updateSSEStatus = function(status) {
            const dot = document.getElementById('sse-status-dot');
            const text = document.getElementById('sse-status-text');
            if (!dot || !text) return;
            
            if (status === 'connected') {
                dot.className = 'sse-dot pulse';
                dot.style.backgroundColor = 'var(--success)';
                text.textContent = 'SSE Connected';
            } else if (status === 'connecting') {
                dot.className = 'sse-dot';
                dot.style.backgroundColor = 'var(--warning)';
                text.textContent = 'Connecting...';
            } else {
                dot.className = 'sse-dot';
                dot.style.backgroundColor = 'var(--danger)';
                text.textContent = 'SSE Disconnected';
            }
        };

        // Real-time Date and Time ticking clock
        function updateDateTime() {
            const dateEl = document.getElementById('current-date');
            const timeEl = document.getElementById('current-time');
            if (!dateEl && !timeEl) return;

            const now = new Date();
            
            // Options for Indonesian locale
            const dateOptions = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            
            if (dateEl) {
                dateEl.textContent = now.toLocaleDateString('id-ID', dateOptions);
            }
            if (timeEl) {
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                timeEl.textContent = `${hours}:${minutes}:${seconds}`;
            }
        }
        
        updateDateTime();
        setInterval(updateDateTime, 1000);

        // Active Link Fallback in Sidebar if needed
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.sidebar .nav-link');
        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (currentPath.startsWith(href) && href !== '/') {
                link.parentElement.classList.add('active');
            }
        });
    });
</script>
