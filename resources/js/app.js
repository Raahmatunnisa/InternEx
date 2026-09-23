// InternEX - script utama aplikasi

document.addEventListener('DOMContentLoaded', () => {
    // Auto-hide flash message setelah beberapa detik
    const flash = document.getElementById('flash-message');
    if (flash) {
        setTimeout(() => {
            flash.style.transition = 'opacity 0.4s ease';
            flash.style.opacity = '0';
            setTimeout(() => flash.remove(), 500);
        }, 4000);
    }

    initPhotoCarousels();
});

// Toggle tampil/sembunyikan password pada field password (login, profil, dsb).
window.togglePasswordVisibility = function (inputId, button) {
    const input = document.getElementById(inputId);
    if (!input) return;
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    const icon = button.querySelector('i');
    if (icon) {
        icon.setAttribute('data-lucide', isHidden ? 'eye-off' : 'eye');
        if (window.lucide) window.lucide.createIcons();
    }
};

// Toggle mobile sidebar drawer
window.toggleMobileSidebar = function () {
    const sidebar = document.getElementById('mobile-sidebar');
    const overlay = document.getElementById('mobile-sidebar-overlay');
    if (sidebar && overlay) {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }
};

// Toggle modal generik berdasarkan id
window.toggleModal = function (id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.toggle('hidden');
        modal.classList.toggle('flex');
    }
};

// Preview nama file yang dipilih pada input file
window.previewFileName = function (input, targetId) {
    const target = document.getElementById(targetId);
    if (target && input.files && input.files.length > 0) {
        target.textContent = input.files[0].name;
        target.classList.remove('hidden');
    }
};

// Counter karakter sederhana untuk textarea
window.bindCharCounter = function (textareaId, counterId, max) {
    const textarea = document.getElementById(textareaId);
    const counter = document.getElementById(counterId);
    if (!textarea || !counter) return;
    const update = () => {
        counter.textContent = `${textarea.value.length} / ${max} karakter`;
    };
    textarea.addEventListener('input', update);
    update();
};

// PhotoCarousel (login hero visual) — vanilla JS, tanpa dependency tambahan.
// Auto-slide setiap N ms (default dari data-interval), pause sementara saat
// user berinteraksi dengan dot/chevron, lalu melanjutkan auto-slide.
function initPhotoCarousels() {
    document.querySelectorAll('[data-carousel]').forEach((root) => {
        const slides = Array.from(root.querySelectorAll('[data-carousel-slide]'));
        const dots = Array.from(root.querySelectorAll('[data-carousel-dot]'));
        if (slides.length <= 1) return;

        const interval = parseInt(root.dataset.interval || '5000', 10);
        let active = 0;
        let timer = null;

        const render = () => {
            slides.forEach((slide, i) => {
                slide.classList.toggle('opacity-100', i === active);
                slide.classList.toggle('opacity-0', i !== active);
            });
            dots.forEach((dot, i) => {
                dot.classList.toggle('w-6', i === active);
                dot.classList.toggle('bg-white', i === active);
                dot.classList.toggle('w-1.5', i !== active);
                dot.classList.toggle('bg-white/40', i !== active);
            });
        };

        const goTo = (index) => {
            active = (index + slides.length) % slides.length;
            render();
        };

        const restartTimer = () => {
            if (timer) clearInterval(timer);
            timer = setInterval(() => goTo(active + 1), interval);
        };

        dots.forEach((dot, i) => {
            dot.addEventListener('click', () => {
                goTo(i);
                restartTimer();
            });
        });

        const prevBtn = root.querySelector('[data-carousel-prev]');
        const nextBtn = root.querySelector('[data-carousel-next]');
        if (prevBtn) prevBtn.addEventListener('click', () => { goTo(active - 1); restartTimer(); });
        if (nextBtn) nextBtn.addEventListener('click', () => { goTo(active + 1); restartTimer(); });

        restartTimer();
    });
}
