<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Webmatic_Services_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'webmatic_services';
    }

    public function get_title() {
        return __( 'Services', 'webmatic' );
    }

    public function get_icon() {
        return 'eicon-info-box';
    }

    public function get_categories() {
        return [ 'webmatic' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Contenu', 'webmatic' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label'   => __( 'Titre de section', 'webmatic' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Nos Services', 'webmatic' ),
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label'   => __( 'Sous-titre', 'webmatic' ),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __( 'Solutions informatiques adaptées à vos besoins', 'webmatic' ),
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label'   => __( 'Nombre de services', 'webmatic' ),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
                'min'     => 1,
                'max'     => 20,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $services = new WP_Query([
            'post_type'      => 'service',
            'posts_per_page' => $settings['posts_per_page'],
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ]);
        ?>
        <section class="services-section">
            <div class="container">
                <div class="section-header">
                    <?php if ( ! empty( $settings['title'] ) ) : ?>
                        <h2><?php echo esc_html( $settings['title'] ); ?></h2>
                    <?php endif; ?>
                    
                    <?php if ( ! empty( $settings['subtitle'] ) ) : ?>
                        <p><?php echo esc_html( $settings['subtitle'] ); ?></p>
                    <?php endif; ?>
                </div>

                <?php if ( $services->have_posts() ) : ?>
                    <div class="services-grid">
                        <?php while ( $services->have_posts() ) : $services->the_post(); 
                            $icon     = get_post_meta(get_the_ID(), 'service_icon', true) ?: 'fas fa-cog';
                            $features = get_post_meta(get_the_ID(), 'service_features', true);
                        ?>
                            <div class="service-card">
                                <div class="service-icon">
                                    <i class="<?php echo esc_attr($icon); ?>"></i>
                                </div>
                                <h3><?php the_title(); ?></h3>
                                <div class="service-description">
                                    <?php the_excerpt(); ?>
                                </div>
                                <?php if ($features && is_array($features)) : ?>
                                    <ul class="service-features">
                                        <?php foreach ($features as $feature) : ?>
                                            <li><i class="fas fa-check"></i> <?php echo esc_html($feature); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                                <a href="<?php the_permalink(); ?>" class="btn-link">
                                    <?php _e( 'En savoir plus', 'webmatic' ); ?> <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                <?php else : ?>
                    <p class="no-results"><?php _e( 'Aucun service disponible.', 'webmatic' ); ?></p>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}