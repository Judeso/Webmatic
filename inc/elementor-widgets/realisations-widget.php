<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Webmatic_Realisations_Widget extends \Elementor\Widget_Base {

    public function get_name() { return 'webmatic_realisations'; }
    public function get_title() { return __( 'Réalisations', 'webmatic' ); }
    public function get_icon() { return 'eicon-gallery-grid'; }
    public function get_categories() { return [ 'webmatic' ]; }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => __( 'Contenu', 'webmatic' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        
        $this->add_control('title', [
            'label'   => __( 'Titre de section', 'webmatic' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Nos Réalisations', 'webmatic' ),
        ]);
        
        $this->add_control('subtitle', [
            'label'   => __( 'Sous-titre', 'webmatic' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __( 'Découvrez nos derniers projets', 'webmatic' ),
        ]);
        
        $this->add_control('posts_per_page', [
            'label'   => __( 'Nombre de réalisations', 'webmatic' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'default' => 6,
            'min'     => 1,
            'max'     => 20,
        ]);
        
        $this->add_control('columns', [
            'label'   => __( 'Colonnes', 'webmatic' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '3',
            'options' => [
                '2' => __( '2 colonnes', 'webmatic' ),
                '3' => __( '3 colonnes', 'webmatic' ),
                '4' => __( '4 colonnes', 'webmatic' ),
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $realisations = new WP_Query([
            'post_type'      => 'realisation',
            'posts_per_page' => $settings['posts_per_page'],
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]);
        ?>
        <section class="realisations-section">
            <div class="container">
                <div class="section-header">
                    <?php if ( ! empty( $settings['title'] ) ) : ?>
                        <h2><?php echo esc_html( $settings['title'] ); ?></h2>
                    <?php endif; ?>
                    
                    <?php if ( ! empty( $settings['subtitle'] ) ) : ?>
                        <p><?php echo esc_html( $settings['subtitle'] ); ?></p>
                    <?php endif; ?>
                </div>

                <?php if ( $realisations->have_posts() ) : ?>
                    <div class="realisations-grid">
                        <?php while ( $realisations->have_posts() ) : $realisations->the_post(); 
                            $url  = get_post_meta(get_the_ID(), 'realisation_url', true);
                            $tags = get_post_meta(get_the_ID(), 'realisation_tags', true);
                        ?>
                            <div class="realisation-card">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="realisation-image">
                                        <?php the_post_thumbnail('webmatic-realisation', array('loading' => 'lazy')); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="realisation-content">
                                    <h3><?php the_title(); ?></h3>
                                    <div class="realisation-excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                    <?php if ($tags && is_array($tags)) : ?>
                                        <div class="realisation-tags">
                                            <?php foreach ($tags as $tag) : ?>
                                                <span class="tag"><?php echo esc_html($tag); ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($url) : ?>
                                        <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="btn-link">
                                            <?php _e( 'Visiter le site', 'webmatic' ); ?> <i class="fas fa-arrow-right"></i>
                                        </a>
                                    <?php else : ?>
                                        <a href="<?php the_permalink(); ?>" class="btn-link">
                                            <?php _e( 'Voir le projet', 'webmatic' ); ?> <i class="fas fa-arrow-right"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                <?php else : ?>
                    <p class="no-results"><?php _e( 'Aucune réalisation disponible.', 'webmatic' ); ?></p>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}