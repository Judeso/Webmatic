<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Webmatic_Testimonials_Widget extends \Elementor\Widget_Base {

    public function get_name() { return 'webmatic_testimonials'; }
    public function get_title() { return __( 'Témoignages', 'webmatic' ); }
    public function get_icon() { return 'eicon-testimonial'; }
    public function get_categories() { return [ 'webmatic' ]; }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => __( 'Contenu', 'webmatic' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        
        $this->add_control('title', [
            'label'   => __( 'Titre de section', 'webmatic' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Ce que disent nos clients', 'webmatic' ),
        ]);
        
        $this->add_control('subtitle', [
            'label'   => __( 'Sous-titre', 'webmatic' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __( 'Découvrez les avis de nos clients satisfaits', 'webmatic' ),
        ]);
        
        $this->add_control('posts_per_page', [
            'label'   => __( 'Nombre de témoignages', 'webmatic' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'default' => 3,
            'min'     => 1,
            'max'     => 20,
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $testimonials = new WP_Query([
            'post_type'      => 'testimonial',
            'posts_per_page' => $settings['posts_per_page'],
            'orderby'        => 'rand',
        ]);
        ?>
        <section class="testimonials-section">
            <div class="container">
                <div class="section-header">
                    <?php if ( ! empty( $settings['title'] ) ) : ?>
                        <h2><?php echo esc_html( $settings['title'] ); ?></h2>
                    <?php endif; ?>
                    
                    <?php if ( ! empty( $settings['subtitle'] ) ) : ?>
                        <p><?php echo esc_html( $settings['subtitle'] ); ?></p>
                    <?php endif; ?>
                </div>

                <?php if ( $testimonials->have_posts() ) : ?>
                    <div class="testimonials-grid">
                        <?php while ( $testimonials->have_posts() ) : $testimonials->the_post(); 
                            $rating      = (int) (get_post_meta(get_the_ID(), 'testimonial_rating', true) ?: 5);
                            $rating      = max(1, min(5, $rating));
                            $author_info = get_post_meta(get_the_ID(), 'testimonial_author_info', true);
                            $initial     = esc_html(mb_substr(get_the_title(), 0, 1));
                        ?>
                            <div class="testimonial-card">
                                <div class="testimonial-header">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <div class="testimonial-avatar">
                                            <?php the_post_thumbnail('webmatic-testimonial', array('loading' => 'lazy')); ?>
                                        </div>
                                    <?php else : ?>
                                        <div class="testimonial-avatar testimonial-avatar-initial">
                                            <?php echo $initial; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="testimonial-author">
                                        <h4><?php the_title(); ?></h4>
                                        <?php if ( $author_info ) : ?>
                                            <p class="author-info"><?php echo esc_html( $author_info ); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="testimonial-rating">
                                    <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                                        <i class="<?php echo ($i <= $rating) ? 'fas' : 'far'; ?> fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                                <div class="testimonial-content">
                                    <?php the_content(); ?>
                                </div>
                            </div>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                <?php else : ?>
                    <p class="no-results"><?php _e( 'Aucun témoignage disponible.', 'webmatic' ); ?></p>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}