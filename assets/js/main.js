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

    // Document ready
    $(document).ready(function () {
        toggleMobileMenu();
        setupSubMenuToggles();
        setupSmoothScroll();
        setupBackToTop();
        setupNewsletterForm();
    });

})(jQuery);
