<?php
/**
 * Critical CSS Inline
 * 
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

/**
 * Générer et injecter le Critical CSS
 */
function webmatic_critical_css() {
    $enabled = get_theme_mod('webmatic_enable_critical_css', true);
    if (!$enabled) return;
    
    // Critical CSS - styles essentiels pour le LCP
    $critical_css = '
/* Critical CSS - Above the fold */

/* Reset & Base */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;line-height:1.6;color:#333;background:#fff}

/* Container */
.container{width:100%;max-width:1200px;margin:0 auto;padding:0 20px}

/* Header Critical */
.site-header{background:#fff;box-shadow:0 2px 10px rgba(0,0,0,.1);position:sticky;top:0;z-index:100}
.header-container{display:flex;align-items:center;justify-content:space-between;height:70px}
.site-title{font-size:1.5rem;font-weight:700;color:#1e3a5f}
.main-navigation{display:flex;align-items:center}

/* Hero Section Critical */
.hero-section{background:linear-gradient(135deg,#1e3a5f 0%,#2c5282 100%);color:#fff;padding:80px 0;min-height:500px;display:flex;align-items:center}
.hero-title{font-size:2.5rem;font-weight:700;margin-bottom:1rem;line-height:1.2}
.hero-subtitle{font-size:1.25rem;margin-bottom:2rem;opacity:.9}
.hero-buttons{display:flex;gap:15px;flex-wrap:wrap}

/* Buttons Critical */
.btn{display:inline-flex;align-items:center;gap:8px;padding:12px 24px;border-radius:4px;font-weight:600;text-decoration:none;transition:all .2s;border:none;cursor:pointer}
.btn-primary{background:#4CAF50;color:#fff}
.btn-secondary{background:rgba(255,255,255,.2);color:#fff}

/* Typography Critical */
h1,h2,h3{font-weight:700;line-height:1.3;color:#1e3a5f}
h1{font-size:2rem}h2{font-size:1.75rem}h3{font-size:1.5rem}
p{margin-bottom:1rem}

/* Images Critical */
img{max-width:100%;height:auto}

/* Accessibility */
.screen-reader-text{position:absolute;left:-10000px}
.skip-link:focus{position:fixed;top:0;left:0;background:#000;color:#fff;padding:8px;z-index:100000}

/* Loading State */
.site-main{min-height:50vh}
';
    
    echo '<style id="critical-css">' . wp_strip_all_tags($critical_css) . '</style>';
    
    // Preload le CSS principal
    ?>
    <link rel="preload" href="<?php echo esc_url(WEBMATIC_THEME_URI . '/assets/css/main.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="<?php echo esc_url(WEBMATIC_THEME_URI . '/assets/css/main.css'); ?>"></noscript>
    <?php
}
add_action('wp_head', 'webmatic_critical_css', 1);

/**
 * Déplacer les scripts en footer pour optimiser le LCP
 */
function webmatic_optimize_scripts() {
    // Remove jQuery migrate
    wp_deregister_script('jquery');
    wp_register_script('jquery', includes_url('/js/jquery/jquery.min.js'), false, null, true);
    
    // Move all scripts to footer
    add_filter('script_loader_tag', function($tag, $handle) {
        if (strpos($tag, 'async') === false && strpos($tag, 'defer') === false) {
            $tag = str_replace('></script>', ' defer></script>', $tag);
        }
        return $tag;
    }, 10, 2);
}
add_action('wp_enqueue_scripts', 'webmatic_optimize_scripts', 1);

/**
 * Option Customizer
 */
function webmatic_critical_css_customizer($wp_customize) {
    $wp_customize->add_setting('webmatic_enable_critical_css', [
        'default' => true,
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_control('webmatic_enable_critical_css', [
        'label' => __('Activer le Critical CSS', 'webmatic'),
        'section' => 'webmatic_homepage',
        'type' => 'checkbox',
        'description' => __('Optimise le LCP (Largest Contentful Paint)', 'webmatic'),
    ]);
}
add_action('customize_register', 'webmatic_critical_css_customizer');
