<?php
/**
 * Widget Logo Carousel pour Elementor
 *
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

class Webmatic_Logo_Carousel_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'webmatic_logo_carousel';
    }

    public function get_title() {
        return __('Carousel Logos', 'webmatic');
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }

    public function get_categories() {
        return ['webmatic'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Logos', 'webmatic'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label' => __('Titre (optionnel)', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Ils nous font confiance', 'webmatic'),
                'label_block' => true,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'logo_image',
            [
                'label' => __('Logo', 'webmatic'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        $repeater->add_control(
            'logo_name',
            [
                'label' => __('Nom (alt text)', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Client', 'webmatic'),
            ]
        );

        $repeater->add_control(
            'logo_url',
            [
                'label' => __('Lien (optionnel)', 'webmatic'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [],
            ]
        );

        $this->add_control(
            'logos',
            [
                'label' => __('Logos', 'webmatic'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ logo_name }}}',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => __('Défilement auto', 'webmatic'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'speed',
            [
                'label' => __('Vitesse (ms)', 'webmatic'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 3000,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'items_to_show',
            [
                'label' => __('Logos visibles', 'webmatic'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '5',
                'options' => [
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="logo-carousel-section">
            <div class="container">
                <?php if (!empty($settings['section_title'])) : ?>
                    <h3 class="carousel-title"><?php echo esc_html($settings['section_title']); ?></h3>
                <?php endif; ?>
                
                <div class="logo-carousel" 
                     data-autoplay="<?php echo esc_attr($settings['autoplay']); ?>"
                     data-speed="<?php echo esc_attr($settings['speed']); ?>">
                    <?php foreach ($settings['logos'] as $logo) : 
                        if (empty($logo['logo_image']['url'])) continue;
                        
                        $tag_start = '<div class="logo-item">';
                        $tag_end = '</div>';
                        
                        if (!empty($logo['logo_url']['url'])) {
                            $target = $logo['logo_url']['is_external'] ? ' target="_blank" rel="noopener noreferrer"' : '';
                            $tag_start = '<a href="' . esc_url($logo['logo_url']['url']) . '" class="logo-item"' . $target . '>';
                            $tag_end = '</a>';
                        }
                        
                        echo $tag_start;
                        ?>
                        <img src="<?php echo esc_url($logo['logo_image']['url']); ?>" 
                             alt="<?php echo esc_attr($logo['logo_name']); ?>"
                             loading="lazy">
                        <?php
                        echo $tag_end;
                    endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
