<?php
/**
 * Dark Mode Toggle et styles
 * 
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

/**
 * Ajouter le toggle dark mode dans le header
 */
function webmatic_dark_mode_toggle() {
    $enabled = get_theme_mod('webmatic_enable_dark_mode', true);
    if (!$enabled) return;
    ?>
    <button class="dark-mode-toggle" aria-label="<?php esc_attr_e('Basculer le mode sombre', 'webmatic'); ?>" aria-pressed="false">
        <span class="dark-mode-icon light">☀️</span>
        <span class="dark-mode-icon dark">🌙</span>
    </button>
    <?php
}
add_action('wp_body_open', 'webmatic_dark_mode_toggle', 5);

/**
 * Ajouter les styles et scripts du dark mode
 */
function webmatic_dark_mode_assets() {
    $enabled = get_theme_mod('webmatic_enable_dark_mode', true);
    if (!$enabled) return;
    ?>
    <style>
        /* Dark Mode Variables */
        :root {
            --bg-color: #ffffff;
            --text-color: #333333;
            --heading-color: #1e3a5f;
            --card-bg: #ffffff;
            --border-color: #e0e0e0;
            --accent-color: #4CAF50;
            --secondary-bg: #f8f9fa;
        }

        [data-theme="dark"] {
            --bg-color: #1a1a2e;
            --text-color: #e0e0e0;
            --heading-color: #ffffff;
            --card-bg: #16213e;
            --border-color: #0f3460;
            --accent-color: #4CAF50;
            --secondary-bg: #0f3460;
        }

        /* Smooth transition */
        body, .site-header, .site-footer, .service-card, .realisation-card, .testimonial-card, .pricing-card {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        /* Dark Mode Toggle Button */
        .dark-mode-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: none;
            background: var(--card-bg);
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            cursor: pointer;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .dark-mode-toggle:hover {
            transform: scale(1.1);
        }

        .dark-mode-icon {
            position: absolute;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        [data-theme="dark"] .dark-mode-icon.light,
        :not([data-theme="dark"]) .dark-mode-icon.dark {
            opacity: 0;
            transform: rotate(180deg);
        }

        [data-theme="dark"] .dark-mode-icon.dark,
        :not([data-theme="dark"]) .dark-mode-icon.light {
            opacity: 1;
            transform: rotate(0);
        }

        /* Apply dark mode colors */
        [data-theme="dark"] body {
            background-color: var(--bg-color);
            color: var(--text-color);
        }

        [data-theme="dark"] h1, [data-theme="dark"] h2, [data-theme="dark"] h3,
        [data-theme="dark"] h4, [data-theme="dark"] h5, [data-theme="dark"] h6 {
            color: var(--heading-color);
        }

        [data-theme="dark"] .service-card,
        [data-theme="dark"] .realisation-card,
        [data-theme="dark"] .testimonial-card,
        [data-theme="dark"] .pricing-card,
        [data-theme="dark"] .team-card {
            background-color: var(--card-bg);
            border-color: var(--border-color);
        }

        [data-theme="dark"] .site-header {
            background-color: var(--card-bg);
        }

        [data-theme="dark"] .services-section,
        [data-theme="dark"] .testimonials-section {
            background-color: var(--secondary-bg);
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.querySelector('.dark-mode-toggle');
        if (!toggle) return;

        // Check for saved preference
        const savedTheme = localStorage.getItem('webmatic-theme');
        if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.setAttribute('data-theme', 'dark');
            toggle.setAttribute('aria-pressed', 'true');
        }

        toggle.addEventListener('click', function() {
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            if (isDark) {
                document.documentElement.removeAttribute('data-theme');
                localStorage.setItem('webmatic-theme', 'light');
                toggle.setAttribute('aria-pressed', 'false');
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
                localStorage.setItem('webmatic-theme', 'dark');
                toggle.setAttribute('aria-pressed', 'true');
            }
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'webmatic_dark_mode_assets', 1);

/**
 * Option Customizer pour activer/désactiver le dark mode
 */
function webmatic_dark_mode_customizer($wp_customize) {
    $wp_customize->add_setting('webmatic_enable_dark_mode', [
        'default' => true,
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_control('webmatic_enable_dark_mode', [
        'label' => __('Activer le mode sombre', 'webmatic'),
        'section' => 'webmatic_footer',
        'type' => 'checkbox',
    ]);
}
add_action('customize_register', 'webmatic_dark_mode_customizer');
