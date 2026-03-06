<?php
/**
 * Critical CSS Inline
 *
 * @package WebMatic
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Injecter le Critical CSS pour le LCP (Above the fold)
 * NOTE : webmatic_optimize_scripts() supprimée car elle cassait
 * Elementor en ajoutant defer à tous les scripts et en
 * déplaçant jQuery en footer.
 */
function webmatic_critical_css() {
    $enabled = get_theme_mod( 'webmatic_enable_critical_css', true );
    if ( ! $enabled ) return;

    $critical_css = '
/* Critical CSS - Above the fold */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;line-height:1.6;color:#333;background:#fff}
.container{width:100%;max-width:1200px;margin:0 auto;padding:0 20px}
.site-header{background:#fff;box-shadow:0 2px 10px rgba(0,0,0,.1);position:sticky;top:0;z-index:1000}
.header-container{display:flex;align-items:center;justify-content:space-between;padding:1rem 20px;max-width:1200px;margin:0 auto}
.site-title{font-size:1.5rem;font-weight:700;color:#1e3a5f;margin:0}
.main-navigation{display:flex;align-items:center;flex:1}
.hero-section{background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:#fff;padding:5rem 0;min-height:500px}
.hero-title{font-size:3rem;font-weight:800;margin-bottom:1.5rem;line-height:1.2}
.hero-subtitle{font-size:1.25rem;margin-bottom:2rem;opacity:.95}
.hero-buttons{display:flex;gap:1rem;margin-bottom:2rem;flex-wrap:wrap}
.btn{display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.5rem;border-radius:8px;font-weight:600;text-decoration:none;transition:all .3s;border:none;cursor:pointer;font-size:1rem}
.btn-primary{background:#2563eb;color:#fff}
.btn-secondary{background:#fff;color:#2563eb}
h1,h2,h3{font-weight:700;line-height:1.3;color:#0f0f10}
img{max-width:100%;height:auto}
.screen-reader-text{position:absolute;left:-10000px;width:1px;height:1px;overflow:hidden}
.skip-link:focus{position:fixed;top:0;left:0;background:#000;color:#fff;padding:8px;z-index:100000}
.site-main{min-height:50vh}
';

    echo '<style id="webmatic-critical-css">' . $critical_css . '</style>' . "\n";
}
add_action( 'wp_head', 'webmatic_critical_css', 2 );

/**
 * Option Customizer
 */
function webmatic_critical_css_customizer( $wp_customize ) {
    $wp_customize->add_setting( 'webmatic_enable_critical_css', array(
        'default'           => true,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'webmatic_enable_critical_css', array(
        'label'       => __( 'Activer le Critical CSS', 'webmatic' ),
        'section'     => 'webmatic_homepage',
        'type'        => 'checkbox',
        'description' => __( 'Optimise le LCP (Largest Contentful Paint)', 'webmatic' ),
    ) );
}
add_action( 'customize_register', 'webmatic_critical_css_customizer' );
