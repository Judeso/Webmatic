<?php
/**
 * Widget Réservation RDV pour Elementor
 *
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

class Webmatic_RDV_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'webmatic_rdv';
    }

    public function get_title() {
        return __('Réservation RDV', 'webmatic');
    }

    public function get_icon() {
        return 'eicon-calendar';
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
            'title',
            [
                'label' => __('Titre', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Prendre rendez-vous', 'webmatic'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Description', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Réservez votre créneau pour une intervention ou une consultation.', 'webmatic'),
            ]
        );

        $this->add_control(
            'show_services',
            [
                'label' => __('Afficher sélection service', 'webmatic'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
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
                'default' => '#f8f9fa',
                'selectors' => [
                    '{{WRAPPER}} .rdv-section' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="rdv-section">
            <div class="container">
                <?php if (!empty($settings['title'])) : ?>
                    <h2 class="section-title"><?php echo esc_html($settings['title']); ?></h2>
                <?php endif; ?>
                
                <?php if (!empty($settings['description'])) : ?>
                    <p class="section-description"><?php echo esc_html($settings['description']); ?></p>
                <?php endif; ?>
                
                <?php echo do_shortcode('[webmatic_rdv_form]'); ?>
            </div>
        </section>
        <?php
    }
}
