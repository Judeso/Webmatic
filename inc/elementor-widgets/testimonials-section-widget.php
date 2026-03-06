<?php
/**
 * Widget Témoignages Section pour Elementor
 *
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

class Webmatic_Testimonials_Section_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'webmatic_testimonials_section';
    }

    public function get_title() {
        return __('Section Témoignages', 'webmatic');
    }

    public function get_icon() {
        return 'eicon-testimonial';
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
                'default' => __('Avis Clients', 'webmatic'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'section_subtitle',
            [
                'label' => __('Sous-titre', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Ce que disent mes clients', 'webmatic'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Nombre de témoignages', 'webmatic'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
                'min' => 1,
                'max' => 20,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => __('Ordre', 'webmatic'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'rand',
                'options' => [
                    'rand' => __('Aléatoire', 'webmatic'),
                    'date' => __('Date', 'webmatic'),
                    'title' => __('Titre', 'webmatic'),
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
                'default' => '#f8f9fa',
                'selectors' => [
                    '{{WRAPPER}} .testimonials-section' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $testimonials = new WP_Query([
            'post_type' => 'testimonial',
            'posts_per_page' => $settings['posts_per_page'],
            'orderby' => $settings['orderby'],
            'no_found_rows' => true,
        ]);
        ?>
        <section class="testimonials-section">
            <div class="container">
                <div class="section-header">
                    <h2><?php echo esc_html($settings['section_title']); ?></h2>
                    <p><?php echo esc_html($settings['section_subtitle']); ?></p>
                </div>

                <div class="testimonials-grid">
                    <?php if ($testimonials->have_posts()) : ?>
                        <?php while ($testimonials->have_posts()) : $testimonials->the_post(); 
                            $rating = (int) (get_post_meta(get_the_ID(), 'testimonial_rating', true) ?: 5);
                            $rating = max(1, min(5, $rating));
                            $author_info = get_post_meta(get_the_ID(), 'testimonial_author_info', true);
                            $initial = esc_html(mb_substr(get_the_title(), 0, 1));
                        ?>
                            <div class="testimonial-card">
                                <div class="testimonial-header">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="testimonial-avatar">
                                            <?php the_post_thumbnail('webmatic-testimonial', ['loading' => 'lazy']); ?>
                                        </div>
                                    <?php else : ?>
                                        <div class="testimonial-avatar testimonial-avatar-initial" aria-hidden="true">
                                            <?php echo $initial; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="testimonial-author">
                                        <h4><?php the_title(); ?></h4>
                                        <?php if ($author_info) : ?>
                                            <p class="author-info"><?php echo esc_html($author_info); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="testimonial-rating" aria-label="<?php echo esc_attr(sprintf(__('Note : %d sur 5', 'webmatic'), $rating)); ?>">
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                        <i class="<?php echo ($i <= $rating) ? 'fas' : 'far'; ?> fa-star" aria-hidden="true"></i>
                                    <?php endfor; ?>
                                </div>
                                <div class="testimonial-content">
                                    <?php the_content(); ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    <?php else : ?>
                        <p class="no-results"><?php esc_html_e('Aucun témoignage pour le moment.', 'webmatic'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
