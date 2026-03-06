<?php
/**
 * Widget Services Section pour Elementor
 *
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

class Webmatic_Services_Section_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'webmatic_services_section';
    }

    public function get_title() {
        return __('Section Services', 'webmatic');
    }

    public function get_icon() {
        return 'eicon-info-box';
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
                'default' => __('Mes Services', 'webmatic'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'section_subtitle',
            [
                'label' => __('Sous-titre', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Solutions complètes pour tous vos besoins informatiques et web', 'webmatic'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Nombre de services', 'webmatic'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => -1,
                'min' => -1,
                'max' => 20,
                'description' => __('-1 pour afficher tous les services', 'webmatic'),
            ]
        );

        $this->add_control(
            'show_link',
            [
                'label' => __('Afficher lien "En savoir plus"', 'webmatic'),
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
                    '{{WRAPPER}} .services-section' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'card_background',
            [
                'label' => __('Fond des cartes', 'webmatic'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .service-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $services = new WP_Query([
            'post_type' => 'service',
            'posts_per_page' => $settings['posts_per_page'],
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'no_found_rows' => true,
        ]);
        ?>
        <section id="services" class="services-section">
            <div class="container">
                <div class="section-header">
                    <h2><?php echo esc_html($settings['section_title']); ?></h2>
                    <p><?php echo esc_html($settings['section_subtitle']); ?></p>
                </div>

                <div class="services-grid">
                    <?php if ($services->have_posts()) : ?>
                        <?php while ($services->have_posts()) : $services->the_post(); 
                            $icon = get_post_meta(get_the_ID(), 'service_icon', true) ?: 'fas fa-cog';
                            $features = get_post_meta(get_the_ID(), 'service_features', true);
                        ?>
                            <div class="service-card">
                                <div class="service-icon">
                                    <i class="<?php echo esc_attr($icon); ?>" aria-hidden="true"></i>
                                </div>
                                <h3><?php the_title(); ?></h3>
                                <div class="service-description">
                                    <?php the_excerpt(); ?>
                                </div>
                                <?php if ($features && is_array($features)) : ?>
                                    <ul class="service-features">
                                        <?php foreach ($features as $feature) : ?>
                                            <li>
                                                <i class="fas fa-check" aria-hidden="true"></i>
                                                <?php echo esc_html($feature); ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                                <?php if ($settings['show_link'] === 'yes') : ?>
                                    <a href="<?php the_permalink(); ?>" class="btn-link">
                                        <?php esc_html_e('En savoir plus', 'webmatic'); ?>
                                        <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    <?php else : ?>
                        <?php echo do_shortcode('[webmatic_default_services]'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
