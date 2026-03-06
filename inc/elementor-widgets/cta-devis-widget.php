<?php
/**
 * Widget CTA Devis pour Elementor
 *
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

class Webmatic_CTA_Devis_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'webmatic_cta_devis';
    }

    public function get_title() {
        return __('CTA Générateur de Devis', 'webmatic');
    }

    public function get_icon() {
        return 'eicon-call-to-action';
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
                'default' => __('Générateur de Devis', 'webmatic'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Description', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Créez votre devis personnalisé en quelques clics et recevez-le instantanément', 'webmatic'),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __('Texte du bouton', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Créer mon devis', 'webmatic'),
            ]
        );

        $this->add_control(
            'button_url',
            [
                'label' => __('URL du bouton', 'webmatic'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [
                    'url' => get_permalink(get_theme_mod('webmatic_devis_page', '')),
                ],
                'placeholder' => __('https://web-matic.fr/devis', 'webmatic'),
            ]
        );

        $this->add_control(
            'button_icon',
            [
                'label' => __('Icône du bouton', 'webmatic'),
                'type' => \Elementor\Controls_Manager::ICON,
                'default' => [
                    'value' => 'fas fa-file-invoice',
                    'library' => 'fa-solid',
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
                'default' => '#1e3a5f',
                'selectors' => [
                    '{{WRAPPER}} .devis-cta-section' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .devis-cta-section' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .devis-cta-section h2' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => __('Couleur du bouton', 'webmatic'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#4CAF50',
                'selectors' => [
                    '{{WRAPPER}} .btn-cta' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="devis-cta-section">
            <div class="container">
                <div class="devis-cta-content">
                    <h2><?php echo esc_html($settings['title']); ?></h2>
                    <p><?php echo esc_html($settings['description']); ?></p>
                    <?php if (!empty($settings['button_url']['url'])) : ?>
                        <a href="<?php echo esc_url($settings['button_url']['url']); ?>" 
                           class="btn btn-cta btn-large"
                           <?php if ($settings['button_url']['is_external']) echo 'target="_blank" rel="noopener noreferrer"'; ?>>
                            <?php if (!empty($settings['button_icon']['value'])) : ?>
                                <i class="<?php echo esc_attr($settings['button_icon']['value']); ?>" aria-hidden="true"></i>
                            <?php endif; ?>
                            <?php echo esc_html($settings['button_text']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
