/**
 * Script pour le slider de partenaires
 */

document.addEventListener('DOMContentLoaded', function () {
    const sliders = document.querySelectorAll('.partners-slider');

    sliders.forEach(function (slider) {
        initPartnerSlider(slider);
    });
});

function initPartnerSlider(sliderElement) {
    const track = sliderElement.querySelector('.slider-track');
    const slides = sliderElement.querySelectorAll('.slider-item');
    const prevBtn = sliderElement.parentElement.querySelector('.slider-prev');
    const nextBtn = sliderElement.parentElement.querySelector('.slider-next');
    const dots = sliderElement.parentElement.parentElement.querySelectorAll('.slider-dot');

    if (!track || !slides.length) return;

    let currentSlide = 0;
    const totalSlides = slides.length;

    // Déterminer le nombre d'items par vue selon la taille d'écran
    function getItemsPerView() {
        if (window.innerWidth <= 480) return 1;
        if (window.innerWidth <= 768) return 2;
        return 4;
    }

    const itemsPerView = getItemsPerView();
    const maxSlides = Math.ceil(totalSlides / itemsPerView);

    function updateSlider() {
        const translateX = -(currentSlide * (100 / itemsPerView));
        track.style.transform = `translateX(${translateX}%)`;

        // Mettre à jour les dots
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentSlide);
        });

        // Mettre à jour l'état des boutons
        prevBtn.style.opacity = currentSlide === 0 ? '0.5' : '1';
        nextBtn.style.opacity = currentSlide === maxSlides - 1 ? '0.5' : '1';
    }

    function nextSlide() {
        if (currentSlide < maxSlides - 1) {
            currentSlide++;
            updateSlider();
        }
    }

    function prevSlide() {
        if (currentSlide > 0) {
            currentSlide--;
            updateSlider();
        }
    }

    function goToSlide(slideIndex) {
        if (slideIndex >= 0 && slideIndex < maxSlides) {
            currentSlide = slideIndex;
            updateSlider();
        }
    }

    // Event listeners
    if (nextBtn) {
        nextBtn.addEventListener('click', nextSlide);
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', prevSlide);
    }

    // Event listeners pour les dots
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => goToSlide(index));
    });

    // Auto-play (optionnel)
    let autoplayInterval;
    function startAutoplay() {
        autoplayInterval = setInterval(() => {
            if (currentSlide === maxSlides - 1) {
                currentSlide = 0;
            } else {
                currentSlide++;
            }
            updateSlider();
        }, 4000); // Change toutes les 4 secondes
    }

    function stopAutoplay() {
        if (autoplayInterval) {
            clearInterval(autoplayInterval);
        }
    }

    // Démarrer l'autoplay
    startAutoplay();

    // Arrêter l'autoplay au survol
    sliderElement.addEventListener('mouseenter', stopAutoplay);
    sliderElement.addEventListener('mouseleave', startAutoplay);

    // Navigation au clavier
    sliderElement.addEventListener('keydown', function (e) {
        switch (e.key) {
            case 'ArrowLeft':
                e.preventDefault();
                prevSlide();
                break;
            case 'ArrowRight':
                e.preventDefault();
                nextSlide();
                break;
        }
    });

    // Support du swipe sur mobile
    let startX = null;
    let startY = null;

    sliderElement.addEventListener('touchstart', function (e) {
        startX = e.touches[0].clientX;
        startY = e.touches[0].clientY;
    });

    sliderElement.addEventListener('touchend', function (e) {
        if (!startX || !startY) return;

        const endX = e.changedTouches[0].clientX;
        const endY = e.changedTouches[0].clientY;

        const diffX = startX - endX;
        const diffY = startY - endY;

        // Vérifier si c'est un swipe horizontal
        if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
            if (diffX > 0) {
                nextSlide();
            } else {
                prevSlide();
            }
        }

        startX = null;
        startY = null;
    });

    // Redimensionnement de la fenêtre
    window.addEventListener('resize', function () {
        // Recalculer et mettre à jour si nécessaire
        updateSlider();
    });

    // Initialisation
    updateSlider();
}
