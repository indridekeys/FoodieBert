/**
 * FoodieBert Main JavaScript File
 * Handles: Category Filtering, Smooth Scrolling, and UI Animations
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Initialize Category Filtering
    // This matches the 'traditional', 'fastfood', and 'bakery' categories we set in the HTML
    window.filterCategory = function(category) {
        const cards = document.querySelectorAll('.res-card');
        const buttons = document.querySelectorAll('.filter-btn');

        // Update active button state
        buttons.forEach(btn => {
            btn.classList.remove('active');
            if (btn.getAttribute('onclick').includes(`'${category}'`)) {
                btn.classList.add('active');
            }
        });

        // Filter cards with animation
        cards.forEach(card => {
            // Remove previous animation classes
            card.classList.remove('show-category');
            
            if (category === 'all' || card.getAttribute('data-category') === category) {
                card.style.display = 'block';
                // Trigger reflow for animation
                void card.offsetWidth; 
                card.classList.add('show-category');
                card.classList.remove('hide-category');
            } else {
                card.classList.add('hide-category');
                // Hide after transition
                setTimeout(() => {
                    if(card.classList.contains('hide-category')) {
                        card.style.display = 'none';
                    }
                }, 400);
            }
        });
    };

    // 2. Smooth Scrolling for Navigation Links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // 3. Floating Badge Interactive Effect
    // Subtle tilt effect when moving mouse over the hero section
    const hero = document.querySelector('.hero-section');
    const badge = document.querySelector('.hero-floating-badge');

    if (hero && badge) {
        hero.addEventListener('mousemove', (e) => {
            const xAxis = (window.innerWidth / 2 - e.pageX) / 25;
            const yAxis = (window.innerHeight / 2 - e.pageY) / 25;
            badge.style.transform = `translate(${xAxis}px, ${yAxis}px)`;
        });

        hero.addEventListener('mouseleave', () => {
            badge.style.transform = `translate(0px, 0px)`;
            badge.style.transition = 'all 0.5s ease';
        });
    }

    // 4. Promo Countdown (Optional)
    // If you want the promo expiry to be dynamic
    const updatePromoExpiry = () => {
        const expiryElement = document.querySelector('.promo-expiry');
        if (expiryElement) {
            const today = new Date();
            const year = today.getFullYear();
            expiryElement.innerText = `* Valid until January 31, ${year}. T&C Apply.`;
        }
    };
    updatePromoExpiry();
});

// 5. Navbar Scroll Effect
window.addEventListener('scroll', () => {
    const header = document.querySelector('header'); // Ensure you have a header tag
    if (header) {
        if (window.scrollY > 50) {
            header.classList.add('header-scrolled');
        } else {
            header.classList.remove('header-scrolled');
        }
    }
});