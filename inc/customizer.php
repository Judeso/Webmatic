<?php
/**
 * Options de personnalisation WordPress Customizer
 * 
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

function webmatic_customize_register($wp_customize) {
    
    // Section Hero
    $wp_customize->add_section('webmatic_hero', array(
        'title' => __('Section Hero', 'webmatic'),
        'priority' => 30,
    ));
    
    $wp_customize->add_setting('webmatic_hero_title', array(
        'default' => __('L\'informatique côté pratique', 'webmatic'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webmatic_hero_title', array(
        'label' => __('Titre Hero', 'webmatic'),
        'section' => 'webmatic_hero',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('webmatic_hero_subtitle', array(
        'default' => __('Développeur web expérimenté et technicien informatique passionné.', 'webmatic'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('webmatic_hero_subtitle', array(
        'label' => __('Sous-titre Hero', 'webmatic'),
        'section' => 'webmatic_hero',
        'type' => 'textarea',
    ));
    
    $wp_customize->add_setting('webmatic_hero_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'webmatic_hero_image', array(
        'label' => __('Image Hero', 'webmatic'),
        'section' => 'webmatic_hero',
    )));
    
    // Section Contact
    $wp_customize->add_section('webmatic_contact', array(
        'title' => __('Informations de Contact', 'webmatic'),
        'priority' => 31,
    ));
    
    $wp_customize->add_setting('webmatic_phone', array(
        'default' => '07 56 91 30 61',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('webmatic_phone', array(
        'label' => __('Téléphone', 'webmatic'),
        'section' => 'webmatic_contact',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('webmatic_email', array(
        'default' => 'contact@web-matic.fr',
        'sanitize_callback' => 'sanitize_email',
    ));
    
    $wp_customize->add_control('webmatic_email', array(
        'label' => __('Email', 'webmatic'),
        'section' => 'webmatic_contact',
        'type' => 'email',
    ));
    
    $wp_customize->add_setting('webmatic_address', array(
        'default' => 'Pommier (69) et région Rhône-Alpes',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('webmatic_address', array(
        'label' => __('Adresse / Zone d\'intervention', 'webmatic'),
        'section' => 'webmatic_contact',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('webmatic_hours', array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('webmatic_hours', array(
        'label' => __('Horaires d\'ouverture', 'webmatic'),
        'section' => 'webmatic_contact',
        'type' => 'textarea',
        'description' => __('Utilisez du HTML pour formater les horaires', 'webmatic'),
    ));
    
    // Réseaux sociaux
    $wp_customize->add_section('webmatic_social', array(
        'title' => __('Réseaux Sociaux', 'webmatic'),
        'priority' => 32,
    ));
    
    $wp_customize->add_setting('webmatic_show_social', array(
        'default' => true,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('webmatic_show_social', array(
        'label' => __('Afficher les réseaux sociaux', 'webmatic'),
        'section' => 'webmatic_social',
        'type' => 'checkbox',
    ));
    
    $social_networks = array(
        'facebook' => 'Facebook',
        'twitter' => 'Twitter',
        'linkedin' => 'LinkedIn',
        'instagram' => 'Instagram',
    );
    
    foreach ($social_networks as $key => $label) {
        $wp_customize->add_setting('webmatic_' . $key, array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control('webmatic_' . $key, array(
            'label' => sprintf(__('URL %s', 'webmatic'), $label),
            'section' => 'webmatic_social',
            'type' => 'url',
        ));
    }
    
    // Section Options de la page d'accueil
    $wp_customize->add_section('webmatic_homepage', array(
        'title' => __('Options Page d\'Accueil', 'webmatic'),
        'priority' => 33,
    ));
    
    $wp_customize->add_setting('webmatic_show_devis_section', array(
        'default' => true,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('webmatic_show_devis_section', array(
        'label' => __('Afficher la section générateur de devis', 'webmatic'),
        'section' => 'webmatic_homepage',
        'type' => 'checkbox',
    ));
    
    $wp_customize->add_setting('webmatic_devis_page', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('webmatic_devis_page', array(
        'label' => __('Page de devis', 'webmatic'),
        'section' => 'webmatic_homepage',
        'type' => 'dropdown-pages',
        'description' => __('Sélectionnez la page utilisant le template "Générateur de Devis"', 'webmatic'),
    ));
    
    // Footer
    $wp_customize->add_section('webmatic_footer', array(
        'title' => __('Pied de page', 'webmatic'),
        'priority' => 34,
    ));
    
    $wp_customize->add_setting('webmatic_copyright_text', array(
        'default' => sprintf(__('&copy; %s WebMatic. Tous droits réservés.', 'webmatic'), date('Y')),
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('webmatic_copyright_text', array(
        'label' => __('Texte de copyright', 'webmatic'),
        'section' => 'webmatic_footer',
        'type' => 'textarea',
    ));
}
add_action('customize_register', 'webmatic_customize_register');