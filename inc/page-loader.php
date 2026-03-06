<?php
/**
 * Page Loader
 * 
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

/**
 * Ajouter le loader dans le header
 */
function webmatic_page_loader() {
    $enabled = get_theme_mod('webmatic_enable_loader', false);
    if (!$enabled) return;
    ?>
    <div id="page-loader" class="page-loader">
        <div class="loader-content">
            <div class="loader-spinner"></div>
            <p class="loader-text"><?php bloginfo('name'); ?></p>
        </div>
    </div>
    <?php
}
add_action('wp_body_open', 'webmatic_page_loader', 1);

/**
 * Ajouter les styles et scripts du loader
 */
function webmatic_loader_assets() {
    $enabled = get_theme_mod('webmatic_enable_loader', false);
    if (!$enabled) return;
    ?>
    <style>
        /* Page Loader Styles */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 99999;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        .page-loader.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .loader-content {
            text-align: center;
        }

        .loader-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid #f3f3f3;
            border-top-color: #1e3a5f;
            border-radius: 50%;
            animation: loader-spin 1s linear infinite;
        }

        @keyframes loader-spin {
            to { transform: rotate(360deg); }
        }

        .loader-text {
            margin-top: 15px;
            color: #1e3a5f;
            font-weight: 600;
            animation: loader-pulse 1.5s ease-in-out infinite;
        }

        @keyframes loader-pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Alternative loader styles */
        .loader-dots {
            display: flex;
            gap: 8px;
        }

        .loader-dots span {
            width: 12px;
            height: 12px;
            background: #1e3a5f;
            border-radius: 50%;
            animation: loader-dots 1.4s ease-in-out infinite both;
        }

        .loader-dots span:nth-child(1) { animation-delay: -0.32s; }
        .loader-dots span:nth-child(2) { animation-delay: -0.16s; }

        @keyframes loader-dots {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const loader = document.getElementById('page-loader');
        if (!loader) return;

        // Hide loader when page is fully loaded
        window.addEventListener('load', function() {
            setTimeout(function() {
                loader.classList.add('hidden');
                
                // Remove from DOM after animation
                setTimeout(function() {
                    loader.remove();
                }, 500);
            }, 500); // Minimum display time
        });

        // Fallback: hide after 5 seconds max
        setTimeout(function() {
            if (loader && !loader.classList.contains('hidden')) {
                loader.classList.add('hidden');
            }
        }, 5000);
    });
    </script>
    <?php
}
add_action('wp_footer', 'webmatic_loader_assets', 0);

/**
 * Option Customizer pour le loader
 */
function webmatic_loader_customizer($wp_customize) {
    $wp_customize->add_setting('webmatic_enable_loader', [
        'default' => false,
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_control('webmatic_enable_loader', [
        'label' => __('Activer le loader de page', 'webmatic'),
        'section' => 'webmatic_homepage',
        'type' => 'checkbox',
        'description' => __('Affiche une animation de chargement', 'webmatic'),
    ]);
}
add_action('customize_register', 'webmatic_loader_customizer');
