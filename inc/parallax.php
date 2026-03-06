<?php
/**
 * Effet Parallaxe JavaScript
 * 
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

/**
 * Ajouter les scripts parallaxe
 */
function webmatic_parallax_assets() {
    ?>
    <style>
        /* Parallax base styles */
        .parallax-container {
            position: relative;
            overflow: hidden;
        }

        .parallax-bg {
            position: absolute;
            top: -20%;
            left: 0;
            width: 100%;
            height: 140%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            will-change: transform;
        }

        .parallax-content {
            position: relative;
            z-index: 1;
        }

        /* Hero parallax */
        .hero-section.parallax {
            position: relative;
            overflow: hidden;
        }

        .hero-parallax-bg {
            position: absolute;
            top: -50%;
            left: -10%;
            width: 120%;
            height: 200%;
            background-size: cover;
            background-position: center;
            will-change: transform;
            opacity: 0.1;
        }

        /* Mouse parallax effect */
        .mouse-parallax {
            transition: transform 0.1s ease-out;
        }

        /* Scroll reveal parallax */
        .parallax-element {
            will-change: transform;
            transition: transform 0.1s linear;
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Parallax scroll effect
        const parallaxElements = document.querySelectorAll('.parallax-bg, .hero-parallax-bg');
        
        let ticking = false;
        
        function updateParallax() {
            const scrollY = window.pageYOffset;
            
            parallaxElements.forEach(el => {
                const rect = el.parentElement.getBoundingClientRect();
                const speed = el.dataset.speed || 0.5;
                
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    const yPos = (scrollY - el.parentElement.offsetTop) * speed;
                    el.style.transform = 'translateY(' + yPos + 'px)';
                }
            });
            
            ticking = false;
        }
        
        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(updateParallax);
                ticking = true;
            }
        });
        
        // Mouse parallax effect
        const mouseParallaxElements = document.querySelectorAll('.mouse-parallax');
        
        if (mouseParallaxElements.length > 0 && !window.matchMedia('(pointer: coarse)').matches) {
            document.addEventListener('mousemove', function(e) {
                const mouseX = e.clientX / window.innerWidth - 0.5;
                const mouseY = e.clientY / window.innerHeight - 0.5;
                
                mouseParallaxElements.forEach(el => {
                    const depth = el.dataset.depth || 20;
                    const x = mouseX * depth;
                    const y = mouseY * depth;
                    el.style.transform = 'translate(' + x + 'px, ' + y + 'px)';
                });
            });
        }
        
        // Element reveal on scroll with parallax
        const revealParallax = document.querySelectorAll('.parallax-element');
        
        if ('IntersectionObserver' in window) {
            const parallaxObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                    }
                });
            }, { threshold: 0.1 });
            
            revealParallax.forEach(el => parallaxObserver.observe(el));
        }
    });
    </script>
    <?php
}
add_action('wp_footer', 'webmatic_parallax_assets', 6);

/**
 * Shortcode pour section parallaxe
 */
function webmatic_parallax_section_shortcode($atts) {
    $atts = shortcode_atts([
        'image' => '',
        'speed' => '0.5',
        'class' => '',
    ], $atts);
    
    ob_start();
    ?>
    <div class="parallax-container <?php echo esc_attr($atts['class']); ?>">
        <?php if (!empty($atts['image'])) : ?>
            <div class="parallax-bg" data-speed="<?php echo esc_attr($atts['speed']); ?>" 
                 style="background-image: url('<?php echo esc_url($atts['image']); ?>');">
            </div>
        <?php endif; ?>
        <div class="parallax-content">
            <?php echo do_shortcode($content); ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('webmatic_parallax', 'webmatic_parallax_section_shortcode');
