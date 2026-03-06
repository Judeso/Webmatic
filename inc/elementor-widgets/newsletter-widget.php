<?php
/**
 * Widget Newsletter pour Elementor
 *
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

class Webmatic_Newsletter_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'webmatic_newsletter';
    }

    public function get_title() {
        return __('Newsletter', 'webmatic');
    }

    public function get_icon() {
        return 'eicon-mail';
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
                'default' => __('Inscrivez-vous à notre newsletter', 'webmatic'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Description', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Recevez nos actualités et conseils informatiques directement dans votre boîte mail.', 'webmatic'),
            ]
        );

        $this->add_control(
            'placeholder',
            [
                'label' => __('Placeholder email', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Votre adresse email', 'webmatic'),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __('Texte bouton', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('S\'inscrire', 'webmatic'),
            ]
        );

        $this->add_control(
            'success_message',
            [
                'label' => __('Message succès', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Inscription réussie ! Merci.', 'webmatic'),
            ]
        );

        $this->add_control(
            'privacy_text',
            [
                'label' => __('Texte confidentialité', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('En vous inscrivant, vous acceptez notre politique de confidentialité.', 'webmatic'),
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
                    '{{WRAPPER}} .newsletter-section' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => __('Couleur bouton', 'webmatic'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1e3a5f',
                'selectors' => [
                    '{{WRAPPER}} .btn-newsletter' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="newsletter-section">
            <div class="container">
                <div class="newsletter-wrapper">
                    <?php if (!empty($settings['title'])) : ?>
                        <h2 class="newsletter-title"><?php echo esc_html($settings['title']); ?></h2>
                    <?php endif; ?>
                    
                    <?php if (!empty($settings['description'])) : ?>
                        <p class="newsletter-description"><?php echo esc_html($settings['description']); ?></p>
                    <?php endif; ?>
                    
                    <form class="newsletter-form" method="post">
                        <?php wp_nonce_field('webmatic_newsletter_nonce', 'newsletter_nonce'); ?>
                        
                        <div class="newsletter-form-group">
                            <input type="email" 
                                   name="newsletter_email" 
                                   class="newsletter-input"
                                   placeholder="<?php echo esc_attr($settings['placeholder']); ?>"
                                   required>
                            <button type="submit" class="btn btn-newsletter">
                                <?php echo esc_html($settings['button_text']); ?>
                            </button>
                        </div>
                        
                        <div class="newsletter-response" style="display:none;" data-success="<?php echo esc_attr($settings['success_message']); ?>"></div>
                        
                        <?php if (!empty($settings['privacy_text'])) : ?>
                            <p class="newsletter-privacy"><?php echo esc_html($settings['privacy_text']); ?></p>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </section>
        <?php
    }
}
