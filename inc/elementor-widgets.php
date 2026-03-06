<?php
/**
 * Widgets personnalisés pour Elementor
 *
 * @package WebMatic
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Enregistrer la catégorie de widgets WebMatic
 */
function webmatic_add_elementor_widget_categories( $elements_manager ) {
    $elements_manager->add_category(
        'webmatic',
        array(
            'title' => __( 'WebMatic', 'webmatic' ),
            'icon'  => 'fa fa-plug',
        )
    );
}
add_action( 'elementor/elements/categories_registered', 'webmatic_add_elementor_widget_categories' );

/**
 * Enregistrer les widgets personnalisés
 */
function webmatic_register_elementor_widgets( $widgets_manager ) {
    $widgets = array(
        // Widgets de base
        'services-widget'       => 'Webmatic_Services_Widget',
        'testimonials-widget'   => 'Webmatic_Testimonials_Widget',
        'realisations-widget'   => 'Webmatic_Realisations_Widget',
        'contact-form-widget'   => 'Webmatic_Contact_Form_Widget',
        // Sections complètes (contenu par défaut du thème)
        'hero-widget'           => 'Webmatic_Hero_Widget',
        'services-section-widget'     => 'Webmatic_Services_Section_Widget',
        'realisations-section-widget' => 'Webmatic_Realisations_Section_Widget',
        'testimonials-section-widget' => 'Webmatic_Testimonials_Section_Widget',
        'contact-section-widget' => 'Webmatic_Contact_Section_Widget',
        // Nouveaux widgets
        'cta-devis-widget'      => 'Webmatic_CTA_Devis_Widget',
        'pricing-widget'        => 'Webmatic_Pricing_Widget',
        'faq-widget'            => 'Webmatic_FAQ_Widget',
        'team-widget'           => 'Webmatic_Team_Widget',
        'stats-widget'          => 'Webmatic_Stats_Widget',
        'logo-carousel-widget'   => 'Webmatic_Logo_Carousel_Widget',
        'process-widget'        => 'Webmatic_Process_Widget',
        'newsletter-widget'     => 'Webmatic_Newsletter_Widget',
        'rdv-widget'            => 'Webmatic_RDV_Widget',
    );

    foreach ( $widgets as $file => $class ) {
        $path = WEBMATIC_THEME_DIR . '/inc/elementor-widgets/' . $file . '.php';
        if ( file_exists( $path ) ) {
            require_once $path;
            if ( class_exists( $class ) ) {
                $widgets_manager->register( new $class() );
            }
        }
    }
}
add_action( 'elementor/widgets/register', 'webmatic_register_elementor_widgets' );