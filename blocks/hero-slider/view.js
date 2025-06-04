document.addEventListener('DOMContentLoaded', function () {
    // Initialiser tous les sliders sur la page
    const sliders = document.querySelectorAll('.hero-slider');

    sliders.forEach(initializeSlider);

    function initializeSlider(sliderElement) {
        const slides = sliderElement.querySelectorAll('.hero-slide');
        const prevButton = sliderElement.querySelector('.hero-nav-prev');
        const nextButton = sliderElement.querySelector('.hero-nav-next');
        const indicatorsContainer = sliderElement.querySelector('.hero-indicators');
        const indicators = indicatorsContainer ? indicatorsContainer.querySelectorAll('.hero-indicator') : [];

        // Récupérer les paramètres depuis les data attributes
        const autoPlay = sliderElement.dataset.autoPlay === 'true';
        const autoPlaySpeed = parseInt(sliderElement.dataset.autoPlaySpeed) || 5000;
        const showNavigation = sliderElement.dataset.showNavigation === 'true';
        const showIndicators = sliderElement.dataset.showIndicators === 'true';

        let currentSlide = 0;
        let slideInterval;

        // Si il n'y a qu'un seul slide, pas besoin d'initialiser la logique du slider
        if (slides.length <= 1) {
            if (prevButton) prevButton.style.display = 'none';
            if (nextButton) nextButton.style.display = 'none';
            if (indicatorsContainer) indicatorsContainer.style.display = 'none';
            return;
        }

        // Masquer les contrôles si nécessaire
        if (!showNavigation) {
            if (prevButton) prevButton.style.display = 'none';
            if (nextButton) nextButton.style.display = 'none';
        }

        if (!showIndicators && indicatorsContainer) {
            indicatorsContainer.style.display = 'none';
        }

        function showSlide(index) {
            // Masquer tous les slides
            slides.forEach((slide) => {
                slide.classList.remove('active');
                const content = slide.querySelector('.hero-content');
                if (content) {
                    content.style.animation = 'none';
                    // Force reflow pour redémarrer l'animation
                    content.offsetHeight;
                }
            });

            // Afficher le slide actuel
            if (slides[index]) {
                slides[index].classList.add('active');
                const activeContent = slides[index].querySelector('.hero-content');
                if (activeContent) {
                    activeContent.style.animation = '';
                }
            }

            // Mettre à jour les indicateurs
            updateIndicators(index);
            currentSlide = index;
        }

        function next() {
            const newSlide = (currentSlide + 1) % slides.length;
            showSlide(newSlide);
        }

        function prev() {
            const newSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(newSlide);
        }

        function updateIndicators(index) {
            indicators.forEach((indicator, i) => {
                if (i === index) {
                    indicator.classList.add('active');
                } else {
                    indicator.classList.remove('active');
                }
            });
        }

        function startSlideInterval() {
            if (autoPlay && slides.length > 1) {
                slideInterval = setInterval(next, autoPlaySpeed);
            }
        }

        function resetSlideInterval() {
            if (slideInterval) {
                clearInterval(slideInterval);
                startSlideInterval();
            }
        }

        // Event listeners pour la navigation
        if (prevButton) {
            prevButton.addEventListener('click', () => {
                prev();
                resetSlideInterval();
            });
        }

        if (nextButton) {
            nextButton.addEventListener('click', () => {
                next();
                resetSlideInterval();
            });
        }

        // Event listeners pour les indicateurs
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                showSlide(index);
                resetSlideInterval();
            });
        });

        // Navigation au clavier
        sliderElement.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                prev();
                resetSlideInterval();
            } else if (e.key === 'ArrowRight') {
                next();
                resetSlideInterval();
            }
        });

        // Pause sur hover (si auto-play activé)
        if (autoPlay) {
            sliderElement.addEventListener('mouseenter', () => {
                if (slideInterval) {
                    clearInterval(slideInterval);
                }
            });

            sliderElement.addEventListener('mouseleave', () => {
                startSlideInterval();
            });
        }

        // Support du swipe sur mobile
        let startX = 0;
        let endX = 0;

        sliderElement.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
        });

        sliderElement.addEventListener('touchmove', (e) => {
            endX = e.touches[0].clientX;
        });

        sliderElement.addEventListener('touchend', () => {
            const threshold = 50; // Seuil minimum pour déclencher le swipe
            const diff = startX - endX;

            if (Math.abs(diff) > threshold) {
                if (diff > 0) {
                    // Swipe vers la gauche - slide suivant
                    next();
                } else {
                    // Swipe vers la droite - slide précédent
                    prev();
                }
                resetSlideInterval();
            }
        });

        // Initialisation
        showSlide(0);
        startSlideInterval();
    }
});
