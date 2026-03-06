<?php
/**
 * Widget Stats/Counter pour Elementor
 *
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

class Webmatic_Stats_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'webmatic_stats';
    }

    public function get_title() {
        return __('Statistiques / Compteurs', 'webmatic');
    }

    public function get_icon() {
        return 'eicon-counter';
    }

    public function get_categories() {
        return ['webmatic'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Statistiques', 'webmatic'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'stat_number',
            [
                'label' => __('Nombre', 'webmatic'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 150,
            ]
        );

        $repeater->add_control(
            'stat_suffix',
            [
                'label' => __('Suffixe', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '+',
                'placeholder' => __('+, %, k, etc.', 'webmatic'),
            ]
        );

        $repeater->add_control(
            'stat_label',
            [
                'label' => __('Label', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Projets réalisés', 'webmatic'),
            ]
        );

        $repeater->add_control(
            'stat_icon',
            [
                'label' => __('Icône', 'webmatic'),
                'type' => \Elementor\Controls_Manager::ICON,
                'default' => [
                    'value' => 'fas fa-check-circle',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'stats_items',
            [
                'label' => __('Statistiques', 'webmatic'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['stat_number' => 150, 'stat_suffix' => '+', 'stat_label' => __('Projets réalisés', 'webmatic'), 'stat_icon' => ['value' => 'fas fa-check-circle']],
                    ['stat_number' => 50, 'stat_suffix' => '+', 'stat_label' => __('Clients satisfaits', 'webmatic'), 'stat_icon' => ['value' => 'fas fa-smile']],
                    ['stat_number' => 10, 'stat_suffix' => '+', 'stat_label' => __('Années d\'expérience', 'webmatic'), 'stat_icon' => ['value' => 'fas fa-calendar-alt']],
                    ['stat_number' => 100, 'stat_suffix' => '%', 'stat_label' => __('Satisfaction client', 'webmatic'), 'stat_icon' => ['value' => 'fas fa-heart']],
                ],
                'title_field' => '{{{ stat_label }}}',
            ]
        );

        $this->add_control(
            'animate',
            [
                'label' => __('Animation compteur', 'webmatic'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => __('Colonnes', 'webmatic'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '4',
                'options' => [
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
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
            'number_color',
            [
                'label' => __('Couleur nombres', 'webmatic'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1e3a5f',
                'selectors' => [
                    '{{WRAPPER}} .stat-number' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __('Couleur icônes', 'webmatic'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#4CAF50',
                'selectors' => [
                    '{{WRAPPER}} .stat-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $columns = 'stats-grid-' . $settings['columns'];
        ?>
        <section class="stats-section">
            <div class="container">
                <div class="stats-grid <?php echo esc_attr($columns); ?>" 
                     data-animate="<?php echo esc_attr($settings['animate']); ?>">
                    <?php foreach ($settings['stats_items'] as $index => $item) : ?>
                        <div class="stat-card" data-target="<?php echo esc_attr($item['stat_number']); ?>">
                            <?php if (!empty($item['stat_icon']['value'])) : ?>
                                <div class="stat-icon">
                                    <i class="<?php echo esc_attr($item['stat_icon']['value']); ?>"></i>
                                </div>
                            <?php endif; ?>
                            <div class="stat-number-wrapper">
                                <span class="stat-number" data-count="<?php echo esc_attr($item['stat_number']); ?>">0</span>
                                <span class="stat-suffix"><?php echo esc_html($item['stat_suffix']); ?></span>
                            </div>
                            <p class="stat-label"><?php echo esc_html($item['stat_label']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
