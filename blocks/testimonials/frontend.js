document.addEventListener('DOMContentLoaded', function() {
    const testimonialBlocks = document.querySelectorAll('.wp-block-mon-theme-aca-testimonials');
    
    testimonialBlocks.forEach(block => {
        const testimonialCards = block.querySelectorAll('.testimonial-card');
        const dots = block.querySelectorAll('.dots-container .dot');
        const prevButton = block.querySelector('.nav-button.prev');
        const nextButton = block.querySelector('.nav-button.next');
        
        let currentTestimonial = 0;
        const totalTestimonials = testimonialCards.length;

        if (totalTestimonials <= 1) {
            if (prevButton) prevButton.style.display = 'none';
            if (nextButton) nextButton.style.display = 'none';
            if (dots.length > 0) block.querySelector('.dots-container').style.display = 'none';
            return;
        }

        const showTestimonial = (index) => {
            testimonialCards.forEach((card, i) => {
                card.style.display = i === index ? 'block' : 'none';
            });
            
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
                if (i === index) {
                    dot.style.transform = 'scale(1.25)';
                    dot.style.backgroundColor = '#2D9B8A';
                } else {
                    dot.style.transform = 'scale(1)';
                    dot.style.backgroundColor = '#A8E6CF';
                }
            });
            currentTestimonial = index;
        };

        const nextTestimonial = () => {
            const newIndex = (currentTestimonial + 1) % totalTestimonials;
            showTestimonial(newIndex);
        };

        const prevTestimonial = () => {
            const newIndex = (currentTestimonial - 1 + totalTestimonials) % totalTestimonials;
            showTestimonial(newIndex);
        };

        nextButton.addEventListener('click', nextTestimonial);
        prevButton.addEventListener('click', prevTestimonial);
        
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => showTestimonial(index));
        });

        // Auto-play
        let autoPlayInterval = setInterval(nextTestimonial, 5000);

        // Optionnel : Arrêter l'autoplay au survol
        const container = block.querySelector('.relative.max-w-4xl');
        container.addEventListener('mouseenter', () => clearInterval(autoPlayInterval));
        container.addEventListener('mouseleave', () => autoPlayInterval = setInterval(nextTestimonial, 5000));

        showTestimonial(0); // Initialiser le premier témoignage
    });
});