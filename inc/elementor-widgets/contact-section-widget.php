<?php
/**
 * Widget Contact Section pour Elementor
 *
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

class Webmatic_Contact_Section_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'webmatic_contact_section';
    }

    public function get_title() {
        return __('Section Contact', 'webmatic');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function get_categories() {
        return ['webmatic'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Contenu', 'webmatic'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label' => __('Titre de section', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Contactez-moi', 'webmatic'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'section_subtitle',
            [
                'label' => __('Sous-titre', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __("N'hésitez pas à me contacter pour discuter de votre projet", 'webmatic'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'show_phone',
            [
                'label' => __('Afficher téléphone', 'webmatic'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'phone',
            [
                'label' => __('Téléphone', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => get_theme_mod('webmatic_phone', '07 56 91 30 61'),
                'condition' => [
                    'show_phone' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_email',
            [
                'label' => __('Afficher email', 'webmatic'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'email',
            [
                'label' => __('Email', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => get_theme_mod('webmatic_email', 'contact@web-matic.fr'),
                'condition' => [
                    'show_email' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_address',
            [
                'label' => __('Afficher adresse', 'webmatic'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'address',
            [
                'label' => __('Adresse', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => get_theme_mod('webmatic_address', 'Pommier (69) et région Rhône-Alpes'),
                'condition' => [
                    'show_address' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_form',
            [
                'label' => __('Afficher formulaire', 'webmatic'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'form_title',
            [
                'label' => __('Titre du formulaire', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Envoyez-moi un message', 'webmatic'),
                'condition' => [
                    'show_form' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Style
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'webmatic'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => __('Couleur de fond', 'webmatic'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .contact-section' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="contact-section">
            <div class="container">
                <div class="section-header">
                    <h2><?php echo esc_html($settings['section_title']); ?></h2>
                    <p><?php echo esc_html($settings['section_subtitle']); ?></p>
                </div>

                <div class="contact-grid">
                    <div class="contact-info">
                        <?php if ($settings['show_phone'] === 'yes') : ?>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-phone" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <h3><?php esc_html_e('Téléphone', 'webmatic'); ?></h3>
                                    <a href="tel:<?php echo esc_attr(str_replace(' ', '', $settings['phone'])); ?>">
                                        <?php echo esc_html($settings['phone']); ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($settings['show_email'] === 'yes') : ?>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <h3><?php esc_html_e('Email', 'webmatic'); ?></h3>
                                    <a href="mailto:<?php echo esc_attr($settings['email']); ?>">
                                        <?php echo esc_html($settings['email']); ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($settings['show_address'] === 'yes') : ?>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <h3><?php esc_html_e("Zone d'intervention", 'webmatic'); ?></h3>
                                    <p><?php echo esc_html($settings['address']); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php $hours = get_theme_mod('webmatic_hours'); if ($hours) : ?>
                            <div class="contact-hours">
                                <h3><?php esc_html_e("Horaires d'ouverture", 'webmatic'); ?></h3>
                                <?php echo wp_kses_post($hours); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if ($settings['show_form'] === 'yes') : ?>
                        <div class="contact-form">
                            <h3><?php echo esc_html($settings['form_title']); ?></h3>
                            <?php echo do_shortcode('[webmatic_contact_form]'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
