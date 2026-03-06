<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Webmatic_Contact_Form_Widget extends \Elementor\Widget_Base {

    public function get_name() { return 'webmatic_contact_form'; }
    public function get_title() { return __( 'Formulaire de contact', 'webmatic' ); }
    public function get_icon() { return 'eicon-form-horizontal'; }
    public function get_categories() { return [ 'webmatic' ]; }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => __( 'Contenu', 'webmatic' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        
        $this->add_control('title', [
            'label'   => __( 'Titre de section', 'webmatic' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Contactez-nous', 'webmatic' ),
        ]);
        
        $this->add_control('subtitle', [
            'label'   => __( 'Sous-titre', 'webmatic' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __( 'Une question ? Nous sommes à votre écoute.', 'webmatic' ),
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="contact-section">
            <div class="container">
                <div class="section-header">
                    <?php if ( ! empty( $settings['title'] ) ) : ?>
                        <h2><?php echo esc_html( $settings['title'] ); ?></h2>
                    <?php endif; ?>
                    
                    <?php if ( ! empty( $settings['subtitle'] ) ) : ?>
                        <p><?php echo esc_html( $settings['subtitle'] ); ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="contact-grid">
                    <div class="contact-info">
                        <?php 
                        $phone = get_theme_mod('webmatic_phone', '07 56 91 30 61');
                        $email = get_theme_mod('webmatic_email', 'contact@web-matic.fr');
                        $address = get_theme_mod('webmatic_address', 'Pommier, 69480');
                        $hours = get_theme_mod('webmatic_hours');
                        ?>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <h3><?php _e('Téléphone', 'webmatic'); ?></h3>
                                <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h3><?php _e('Email', 'webmatic'); ?></h3>
                                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h3><?php _e("Zone d'intervention", 'webmatic'); ?></h3>
                                <p><?php echo esc_html($address); ?></p>
                            </div>
                        </div>
                        
                        <?php if ($hours) : ?>
                            <div class="contact-hours">
                                <h3><?php _e("Horaires d'ouverture", 'webmatic'); ?></h3>
                                <?php echo wp_kses_post($hours); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="contact-form">
                        <h3><?php _e('Envoyez-moi un message', 'webmatic'); ?></h3>
                        <?php echo do_shortcode('[webmatic_contact_form]'); ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}