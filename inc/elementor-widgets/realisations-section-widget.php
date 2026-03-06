<?php
/**
 * Widget Réalisations Section pour Elementor
 *
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

class Webmatic_Realisations_Section_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'webmatic_realisations_section';
    }

    public function get_title() {
        return __('Section Réalisations', 'webmatic');
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
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
                'default' => __('Mes Réalisations', 'webmatic'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'section_subtitle',
            [
                'label' => __('Sous-titre', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __("Découvrez quelques projets que j'ai eu le plaisir de réaliser", 'webmatic'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Nombre de réalisations', 'webmatic'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
                'min' => 1,
                'max' => 20,
            ]
        );

        $this->add_control(
            'show_link',
            [
                'label' => __('Afficher lien "Visiter le site"', 'webmatic'),
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
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .realisations-section' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $realisations = new WP_Query([
            'post_type' => 'realisation',
            'posts_per_page' => $settings['posts_per_page'],
            'orderby' => 'date',
            'order' => 'DESC',
            'no_found_rows' => true,
        ]);
        ?>
        <section class="realisations-section">
            <div class="container">
                <div class="section-header">
                    <h2><?php echo esc_html($settings['section_title']); ?></h2>
                    <p><?php echo esc_html($settings['section_subtitle']); ?></p>
                </div>

                <div class="realisations-grid">
                    <?php if ($realisations->have_posts()) : ?>
                        <?php while ($realisations->have_posts()) : $realisations->the_post(); 
                            $url = get_post_meta(get_the_ID(), 'realisation_url', true);
                            $tags = get_post_meta(get_the_ID(), 'realisation_tags', true);
                        ?>
                            <div class="realisation-card">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="realisation-image">
                                        <?php the_post_thumbnail('webmatic-realisation', ['loading' => 'lazy']); ?>
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
                                    <?php if ($url && $settings['show_link'] === 'yes') : ?>
                                        <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="btn-link">
                                            <?php esc_html_e('Visiter le site', 'webmatic'); ?>
                                            <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    <?php else : ?>
                        <p class="no-results"><?php esc_html_e('Aucune réalisation pour le moment.', 'webmatic'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
