/**
 * Main JavaScript file for Mon-Theme-ACA
 *
 * Contains handlers for navigation, responsive features, and interactive elements
 */
(function ($) {
    'use strict';

    // Toggle mobile menu
    function toggleMobileMenu() {
        const navToggle = document.querySelector('.menu-toggle');
        const primaryMenu = document.querySelector('#primary-menu');

        if (!navToggle || !primaryMenu) return;

        navToggle.addEventListener('click', function () {
            const expanded = navToggle.getAttribute('aria-expanded') === 'true' || false;
            navToggle.setAttribute('aria-expanded', !expanded);
            primaryMenu.classList.toggle('toggled');
        });
    }

    // Add sub-menu toggle for mobile navigation
    function setupSubMenuToggles() {
        const hasChildren = document.querySelectorAll('.menu-item-has-children');

        if (!hasChildren.length) return;

        hasChildren.forEach(function (item) {
            const button = document.createElement('button');
            button.className = 'submenu-toggle';
            button.setAttribute('aria-expanded', 'false');
            button.innerHTML = '<span class="screen-reader-text">Toggle sub-menu</span>';

            item.appendChild(button);

            button.addEventListener('click', function (e) {
                e.preventDefault();
                const expanded = button.getAttribute('aria-expanded') === 'true' || false;
                button.setAttribute('aria-expanded', !expanded);
                item.classList.toggle('submenu-open');
            });
        });
    }

    // Add smooth scrolling to anchor links
    function setupSmoothScroll() {
        $('a[href*="#"]:not([href="#"])').on('click', function () {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
                let target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 50
                    }, 800);
                    return false;
                }
            }
        });
    }

    // Back to top button
    function setupBackToTop() {
        const backToTop = document.querySelector('.back-to-top');

        if (!backToTop) return;

        window.addEventListener('scroll', function () {
            if (window.pageYOffset > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });

        backToTop.addEventListener('click', function (e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Newsletter form enhancement
    function setupNewsletterForm() {
        const form = document.getElementById('newsletter-form');
        const emailInput = document.getElementById('newsletter-email');

        if (form && emailInput) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const email = emailInput.value.trim();
                const button = form.querySelector('button[type="submit"]');
                const buttonText = button.querySelector('span');
                const buttonIcon = button.querySelector('i');

                // Simple email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!emailRegex.test(email)) {
                    // Show error state
                    emailInput.classList.add('ring-red-500', 'ring-2');
                    emailInput.classList.remove('focus:ring-[#A8E6CF]');

                    setTimeout(() => {
                        emailInput.classList.remove('ring-red-500', 'ring-2');
                        emailInput.classList.add('focus:ring-[#A8E6CF]');
                    }, 3000);

                    return;
                }

                // Show loading state
                button.disabled = true;
                buttonText.textContent = 'Inscription en cours...';
                buttonIcon.className = 'fas fa-spinner fa-spin ml-2';
                button.classList.add('opacity-75');

                // Simulate API call
                setTimeout(() => {
                    // Show success state
                    buttonText.textContent = 'Inscrit avec succès !';
                    buttonIcon.className = 'fas fa-check ml-2 success-icon';
                    button.classList.remove('bg-[#28A745]', 'hover:bg-[#28A745]/90');
                    button.classList.add('newsletter-success');

                    // Reset form
                    emailInput.value = '';

                    // Reset button after 3 seconds
                    setTimeout(() => {
                        button.disabled = false;
                        buttonText.textContent = 'S\'inscrire maintenant';
                        buttonIcon.className = 'fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1';
                        button.classList.remove('newsletter-success', 'opacity-75');
                        button.classList.add('bg-[#28A745]', 'hover:bg-[#28A745]/90');
                    }, 3000);
                }, 1500);
            });
        }
    }

    // Comments system enhancements
    function setupCommentSystem() {
        // Smooth scroll to comment form when reply link is clicked
        $(document).on('click', '.comment-reply-link', function (e) {
            // Let WordPress handle the reply functionality first
            setTimeout(function () {
                const respondElement = document.getElementById('respond');
                if (respondElement) {
                    respondElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            }, 100);
        });

        // Smooth scroll to comment form when cancel reply link is clicked
        $(document).on('click', '#cancel-comment-reply-link', function (e) {
            setTimeout(function () {
                const respondElement = document.getElementById('respond');
                if (respondElement) {
                    respondElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            }, 100);
        });

        // Add visual feedback for comment submission
        $('#commentform').on('submit', function () {
            const submitButton = $(this).find('input[type="submit"]');
            submitButton.prop('disabled', true);
            submitButton.val('Publication en cours...');
        });
    }

    // Search toggle functionality
    function setupSearchToggle() {
        const searchToggle = document.querySelector('.search-toggle');
        const searchForm = document.querySelector('.header-search-form');

        if (!searchToggle || !searchForm) return;

        searchToggle.addEventListener('click', function (e) {
            e.preventDefault();
            searchForm.classList.toggle('active');
            const input = searchForm.querySelector('input[type="search"]');
            if (input && searchForm.classList.contains('active')) {
                input.focus();
            }
        });

        // Close search on escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && searchForm.classList.contains('active')) {
                searchForm.classList.remove('active');
            }
        });
    }

    // Load more functionality
    function setupLoadMore() {
        const loadMoreBtn = document.querySelector('.load-more-btn');

        if (!loadMoreBtn) return;

        loadMoreBtn.addEventListener('click', function (e) {
            e.preventDefault();

            const button = e.target;
            const page = parseInt(button.dataset.page) || 1;
            const maxPages = parseInt(button.dataset.maxPages) || 1;

            if (page >= maxPages) {
                button.style.display = 'none';
                return;
            }

            button.textContent = 'Chargement...';
            button.disabled = true;

            // Here you would typically make an AJAX call to load more posts
            // For now, we'll just simulate it
            setTimeout(() => {
                button.textContent = 'Charger plus';
                button.disabled = false;
                button.dataset.page = page + 1;

                if (page + 1 >= maxPages) {
                    button.style.display = 'none';
                }
            }, 1000);
        });
    }

    // Form validation enhancement
    function setupFormValidation() {
        const forms = document.querySelectorAll('form.validate');

        forms.forEach(form => {
            form.addEventListener('submit', function (e) {
                const emailInputs = form.querySelectorAll('input[type="email"]');
                const requiredInputs = form.querySelectorAll('input[required], textarea[required]');

                let isValid = true;

                // Validate required fields
                requiredInputs.forEach(input => {
                    if (!input.value.trim()) {
                        input.classList.add('error');
                        isValid = false;
                    } else {
                        input.classList.remove('error');
                    }
                });

                // Validate email fields
                emailInputs.forEach(input => {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (input.value && !emailRegex.test(input.value)) {
                        input.classList.add('error');
                        isValid = false;
                    } else if (input.value) {
                        input.classList.remove('error');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    }

    // Scroll to top functionality
    function setupScrollToTop() {
        const scrollToTopBtn = document.querySelector('.scroll-to-top');

        if (!scrollToTopBtn) return;

        window.addEventListener('scroll', function () {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.classList.add('visible');
            } else {
                scrollToTopBtn.classList.remove('visible');
            }
        });

        scrollToTopBtn.addEventListener('click', function (e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Initialize sliders
    function initializeSliders() {
        // This would typically initialize any slider/carousel functionality
        // For now, we'll just add basic functionality for elements with slider class
        const sliders = document.querySelectorAll('.slider, .carousel');

        sliders.forEach(slider => {
            const slides = slider.querySelectorAll('.slide, .carousel-item');
            const prevBtn = slider.querySelector('.prev, .carousel-prev');
            const nextBtn = slider.querySelector('.next, .carousel-next');

            if (slides.length === 0) return;

            let currentSlide = 0;

            function showSlide(index) {
                slides.forEach((slide, i) => {
                    slide.classList.toggle('active', i === index);
                });
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    currentSlide = currentSlide > 0 ? currentSlide - 1 : slides.length - 1;
                    showSlide(currentSlide);
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    currentSlide = currentSlide < slides.length - 1 ? currentSlide + 1 : 0;
                    showSlide(currentSlide);
                });
            }

            // Initialize first slide
            showSlide(0);
        });
    }

    // Document ready
    $(document).ready(function () {
        toggleMobileMenu();
        setupSubMenuToggles();
        setupSmoothScroll();
        setupSearchToggle();
        setupLoadMore();
        setupFormValidation();
        setupScrollToTop();
        initializeSliders();
        // Add comment system enhancements
        setupCommentSystem();
    });

})(jQuery);
