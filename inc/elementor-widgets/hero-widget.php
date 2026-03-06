<?php
/**
 * Widget Hero Section pour Elementor
 *
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

class Webmatic_Hero_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'webmatic_hero';
    }

    public function get_title() {
        return __('Hero Section', 'webmatic');
    }

    public function get_icon() {
        return 'eicon-banner';
    }

    public function get_categories() {
        return ['webmatic'];
    }

    protected function register_controls() {
        // Section Contenu
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Contenu', 'webmatic'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Titre', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __("L'informatique côté pratique", 'webmatic'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label' => __('Sous-titre', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Développeur web expérimenté et technicien informatique passionné. Solutions créatives pour votre présence en ligne et maintenance complète de vos équipements.', 'webmatic'),
            ]
        );

        $this->add_control(
            'show_primary_button',
            [
                'label' => __('Afficher bouton principal', 'webmatic'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'primary_button_text',
            [
                'label' => __('Texte bouton principal', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Découvrir mes services', 'webmatic'),
                'condition' => [
                    'show_primary_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'primary_button_url',
            [
                'label' => __('URL bouton principal', 'webmatic'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [
                    'url' => '#services',
                ],
                'condition' => [
                    'show_primary_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_secondary_button',
            [
                'label' => __('Afficher bouton secondaire', 'webmatic'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'secondary_button_text',
            [
                'label' => __('Texte bouton secondaire', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => get_theme_mod('webmatic_phone', '07 56 91 30 61'),
                'condition' => [
                    'show_secondary_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'secondary_button_url',
            [
                'label' => __('URL bouton secondaire', 'webmatic'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [
                    'url' => 'tel:' . str_replace(' ', '', get_theme_mod('webmatic_phone', '0756913061')),
                ],
                'condition' => [
                    'show_secondary_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_features',
            [
                'label' => __('Afficher features', 'webmatic'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'feature_1',
            [
                'label' => __('Feature 1', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Devis gratuit', 'webmatic'),
                'condition' => [
                    'show_features' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'feature_2',
            [
                'label' => __('Feature 2', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Intervention rapide', 'webmatic'),
                'condition' => [
                    'show_features' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'hero_image',
            [
                'label' => __('Image Hero', 'webmatic'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => get_theme_mod('webmatic_hero_image', ''),
                ],
            ]
        );

        $this->end_controls_section();

        // Section Style
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
                'default' => '#1e3a5f',
                'selectors' => [
                    '{{WRAPPER}} .hero-section' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __('Couleur du texte', 'webmatic'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .hero-section' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="hero-section">
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title"><?php echo esc_html($settings['title']); ?></h1>
                    <p class="hero-subtitle"><?php echo esc_html($settings['subtitle']); ?></p>
                    
                    <div class="hero-buttons">
                        <?php if ($settings['show_primary_button'] === 'yes') : ?>
                            <a href="<?php echo esc_url($settings['primary_button_url']['url']); ?>" class="btn btn-primary">
                                <i class="fas fa-bolt" aria-hidden="true"></i>
                                <?php echo esc_html($settings['primary_button_text']); ?>
                            </a>
                        <?php endif; ?>
                        
                        <?php if ($settings['show_secondary_button'] === 'yes') : ?>
                            <a href="<?php echo esc_url($settings['secondary_button_url']['url']); ?>" class="btn btn-secondary">
                                <i class="fas fa-phone" aria-hidden="true"></i>
                                <?php echo esc_html($settings['secondary_button_text']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ($settings['show_features'] === 'yes') : ?>
                        <div class="hero-features">
                            <span><i class="fas fa-check-circle" aria-hidden="true"></i> <?php echo esc_html($settings['feature_1']); ?></span>
                            <span><i class="fas fa-clock" aria-hidden="true"></i> <?php echo esc_html($settings['feature_2']); ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($settings['hero_image']['url'])) : ?>
                    <div class="hero-image">
                        <img src="<?php echo esc_url($settings['hero_image']['url']); ?>"
                             alt="<?php esc_attr_e('Innovation technologique', 'webmatic'); ?>"
                             loading="eager">
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}
