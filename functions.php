<?php
/**
 * WebMatic Theme Functions
 *
 * @package WebMatic
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Constantes du thème
define( 'WEBMATIC_VERSION', '1.0.0' );
define( 'WEBMATIC_THEME_DIR', get_template_directory() );
define( 'WEBMATIC_THEME_URI', get_template_directory_uri() );

// ============================================================
// 1. CONFIGURATION DU THÈME
// ============================================================

function webmatic_setup() {
    // Traductions
    load_theme_textdomain( 'webmatic', WEBMATIC_THEME_DIR . '/languages' );

    // Supports WordPress
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'elementor' );

    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 250,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Menus
    register_nav_menus( array(
        'primary' => __( 'Menu Principal', 'webmatic' ),
        'footer'  => __( 'Menu Pied de page', 'webmatic' ),
    ) );

    // Tailles d'images
    add_image_size( 'webmatic-service',     400, 300, true );
    add_image_size( 'webmatic-realisation', 800, 600, true );
    add_image_size( 'webmatic-testimonial', 100, 100, true );
}
add_action( 'after_setup_theme', 'webmatic_setup' );

// ============================================================
// 2. SCRIPTS ET STYLES
// ============================================================

function webmatic_enqueue_scripts() {

    // ── Styles ──────────────────────────────────────────────

    // Style principal du thème
    wp_enqueue_style(
        'webmatic-style',
        get_stylesheet_uri(),
        array(),
        WEBMATIC_VERSION
    );

    // CSS principal
    wp_enqueue_style(
        'webmatic-main',
        WEBMATIC_THEME_URI . '/assets/css/main.css',
        array(),
        WEBMATIC_VERSION
    );

    // Font Awesome — CDN
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
        array(),
        '6.4.0'
    );

    // CSS des widgets
    wp_enqueue_style(
        'webmatic-widgets',
        WEBMATIC_THEME_URI . '/assets/css/widgets.css',
        array(),
        WEBMATIC_VERSION
    );

    // ── Scripts ─────────────────────────────────────────────

    // Script principal
    wp_enqueue_script(
        'webmatic-main',
        WEBMATIC_THEME_URI . '/assets/js/main.js',
        array( 'jquery' ),
        WEBMATIC_VERSION,
        true
    );

    // Fil de commentaires
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    // ── Page devis uniquement ────────────────────────────────

    if ( is_page_template( 'page-devis.php' ) ) {
        wp_enqueue_style(
            'webmatic-devis',
            WEBMATIC_THEME_URI . '/assets/css/devis.css',
            array(),
            WEBMATIC_VERSION
        );
        wp_enqueue_script(
            'webmatic-devis',
            WEBMATIC_THEME_URI . '/assets/js/devis-generator.js',
            array( 'jquery' ),
            WEBMATIC_VERSION,
            true
        );
        wp_localize_script( 'webmatic-devis', 'webmaticAjax', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'webmatic_devis_nonce' ),
        ) );
    }
}
add_action( 'wp_enqueue_scripts', 'webmatic_enqueue_scripts' );

// ============================================================
// 3. ZONES DE WIDGETS
// ============================================================

function webmatic_widgets_init() {
    $sidebars = array(
        array( 'name' => __( 'Sidebar', 'webmatic' ),  'id' => 'sidebar-1', 'desc' => __( 'Zone de widgets sidebar', 'webmatic' ) ),
        array( 'name' => __( 'Footer 1', 'webmatic' ), 'id' => 'footer-1',  'desc' => __( 'Footer colonne 1', 'webmatic' ) ),
        array( 'name' => __( 'Footer 2', 'webmatic' ), 'id' => 'footer-2',  'desc' => __( 'Footer colonne 2', 'webmatic' ) ),
        array( 'name' => __( 'Footer 3', 'webmatic' ), 'id' => 'footer-3',  'desc' => __( 'Footer colonne 3', 'webmatic' ) ),
    );

    foreach ( $sidebars as $s ) {
        register_sidebar( array(
            'name'          => $s['name'],
            'id'            => $s['id'],
            'description'   => $s['desc'],
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
    }
}
add_action( 'widgets_init', 'webmatic_widgets_init' );

// ============================================================
// 4. ELEMENTOR
// ============================================================

function webmatic_register_elementor_locations( $elementor_theme_manager ) {
    $elementor_theme_manager->register_all_core_location();
}
add_action( 'elementor/theme/register_locations', 'webmatic_register_elementor_locations' );

function webmatic_is_elementor_active() {
    return did_action( 'elementor/loaded' );
}

function webmatic_is_elementor_edited( $post_id = null ) {
    if ( ! webmatic_is_elementor_active() ) return false;
    if ( ! $post_id ) $post_id = get_the_ID();
    if ( ! $post_id ) return false;
    return \Elementor\Plugin::$instance->db->is_built_with_elementor( $post_id );
}

function webmatic_load_elementor_widgets() {
    $file = WEBMATIC_THEME_DIR . '/inc/elementor-widgets.php';
    if ( file_exists( $file ) ) require_once $file;
}
add_action( 'elementor/init', 'webmatic_load_elementor_widgets' );

// ============================================================
// 5. INCLUSION DES FICHIERS
// ============================================================

$webmatic_includes = array(
    '/inc/custom-post-types.php',
    '/inc/shortcodes.php',
    '/inc/customizer.php',
    '/inc/admin-devis.php',
    '/inc/dark-mode.php',
    '/inc/animations.php',
    '/inc/parallax.php',
    '/inc/page-loader.php',
    '/inc/breadcrumb.php',
    '/inc/toasts.php',
    '/inc/lazy-loading.php',
    '/inc/critical-css.php',   // ← version corrigée (sans optimize_scripts)
    '/inc/schema-org.php',
    '/inc/sitemap.php',
    '/inc/reservation-rdv.php',
);

foreach ( $webmatic_includes as $file ) {
    $path = WEBMATIC_THEME_DIR . $file;
    if ( file_exists( $path ) ) require_once $path;
}

// ============================================================
// 6. CLASSES BODY
// ============================================================

function webmatic_body_classes( $classes ) {
    if ( is_front_page() )                    $classes[] = 'webmatic-home';
    if ( is_singular() )                      $classes[] = 'webmatic-singular';
    if ( is_page_template( 'page-devis.php' ) ) $classes[] = 'webmatic-devis';
    return $classes;
}
add_filter( 'body_class', 'webmatic_body_classes' );

// ============================================================
// 7. EXCERPT
// ============================================================

add_filter( 'excerpt_length', function() { return 30; } );
add_filter( 'excerpt_more',   function() { return '&hellip;'; } );

// ============================================================
// 8. SÉCURITÉ
// ============================================================

remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );