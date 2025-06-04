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

    // Document ready
    $(document).ready(function () {
        toggleMobileMenu();
        setupSubMenuToggles();
        setupSmoothScroll();
        setupBackToTop();
    });

})(jQuery);
