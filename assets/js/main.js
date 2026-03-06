/**
 * WebMatic Theme Main JavaScript
 * @package WebMatic
 */

(function($) {
    'use strict';
    
    /**
     * Menu mobile toggle
     */
    $('.menu-toggle').on('click', function() {
        $(this).toggleClass('active');
        $('.main-navigation').toggleClass('active');
    });
    
    /**
     * Smooth scroll pour les liens d'ancrage
     */
    $('a[href^="#"]').on('click', function(e) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 80
            }, 800);
        }
    });
    
    /**
     * Champs entreprise dans le formulaire de devis
     */
    $('#type_client').on('change', function() {
        if ($(this).val() === 'entreprise') {
            $('#entreprise-fields').slideDown();
            $('#entreprise-fields input').prop('required', true);
        } else {
            $('#entreprise-fields').slideUp();
            $('#entreprise-fields input').prop('required', false);
        }
    });
    
    /**
     * Animation au scroll
     */
    function animateOnScroll() {
        $('.service-card, .realisation-card, .testimonial-card').each(function() {
            var elementTop = $(this).offset().top;
            var elementBottom = elementTop + $(this).outerHeight();
            var viewportTop = $(window).scrollTop();
            var viewportBottom = viewportTop + $(window).height();
            
            if (elementBottom > viewportTop && elementTop < viewportBottom) {
                $(this).addClass('animated');
            }
        });
    }
    
    $(window).on('scroll', function() {
        animateOnScroll();
    });
    
    // Trigger au chargement
    animateOnScroll();
    
    /**
     * Header sticky
     */
    var lastScrollTop = 0;
    $(window).scroll(function() {
        var scrollTop = $(this).scrollTop();
        
        if (scrollTop > 100) {
            $('.site-header').addClass('scrolled');
        } else {
            $('.site-header').removeClass('scrolled');
        }
        
        lastScrollTop = scrollTop;
    });
    
})(jQuery);

/**
 * Vanilla JS pour les fonctionnalités de base
 */
document.addEventListener('DOMContentLoaded', function() {
    
    // Ajouter la classe 'loaded' au body
    document.body.classList.add('loaded');
    
    // Back to top button (si vous voulez l'ajouter)
    // Code ici si nécessaire
    
});