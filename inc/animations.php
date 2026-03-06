<?php
/**
 * Micro-animations CSS et JavaScript
 * 
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

/**
 * Ajouter les styles et scripts d'animation
 */
function webmatic_animations_assets() {
    ?>
    <style>
        /* Fade In Up Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease forwards;
        }

        /* Fade In Left/Right */
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .animate-fade-in-left {
            animation: fadeInLeft 0.6s ease forwards;
        }

        .animate-fade-in-right {
            animation: fadeInRight 0.6s ease forwards;
        }

        /* Zoom In */
        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }

        .animate-zoom-in {
            animation: zoomIn 0.5s ease forwards;
        }

        /* Pulse */
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .animate-pulse {
            animation: pulse 2s ease-in-out infinite;
        }

        /* Float */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        /* Shake on hover */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .hover-shake:hover {
            animation: shake 0.4s ease;
        }

        /* Card hover effects */
        .service-card, .realisation-card, .testimonial-card, .pricing-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .service-card:hover, .realisation-card:hover, .testimonial-card:hover, .pricing-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        /* Button hover effects */
        .btn {
            transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .btn:active {
            transform: translateY(0);
        }

        /* Image hover zoom */
        .realisation-image img, .team-photo img {
            transition: transform 0.3s ease;
        }

        .realisation-card:hover .realisation-image img,
        .team-card:hover .team-photo img {
            transform: scale(1.05);
        }

        /* Link underline animation */
        .btn-link {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: currentColor;
            transition: width 0.3s ease;
        }

        .btn-link:hover::after {
            width: 100%;
        }

        .btn-link i {
            transition: transform 0.2s ease;
        }

        .btn-link:hover i {
            transform: translateX(3px);
        }

        /* Intersection Observer base styles */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Stagger delays */
        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }
        .reveal-delay-4 { transition-delay: 0.4s; }

        /* Loading skeleton */
        @keyframes skeleton {
            0% { background-position: -200px 0; }
            100% { background-position: 200px 0; }
        }

        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 400px 100%;
            animation: skeleton 1.5s ease-in-out infinite;
        }

        /* Icon spin on hover */
        .service-icon, .contact-icon {
            transition: transform 0.3s ease;
        }

        .service-card:hover .service-icon,
        .contact-item:hover .contact-icon {
            transform: rotate(10deg) scale(1.1);
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Intersection Observer for scroll animations
        const revealElements = document.querySelectorAll('.reveal, .service-card, .realisation-card, .testimonial-card, .pricing-card, .team-card, .stat-card');
        
        if ('IntersectionObserver' in window) {
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.classList.add('active');
                        }, index * 100);
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            revealElements.forEach(el => {
                el.classList.add('reveal');
                revealObserver.observe(el);
            });
        } else {
            // Fallback for older browsers
            revealElements.forEach(el => {
                el.classList.add('active');
            });
        }

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    e.preventDefault();
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'webmatic_animations_assets', 5);
