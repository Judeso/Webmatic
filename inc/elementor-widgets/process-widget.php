<?php
/**
 * Widget Process Steps pour Elementor
 *
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

class Webmatic_Process_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'webmatic_process';
    }

    public function get_title() {
        return __('Étapes / Process', 'webmatic');
    }

    public function get_icon() {
        return 'eicon-number-field';
    }

    public function get_categories() {
        return ['webmatic'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Étapes', 'webmatic'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label' => __('Titre de section', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Comment ça marche', 'webmatic'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'layout',
            [
                'label' => __('Disposition', 'webmatic'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => __('Horizontal', 'webmatic'),
                    'vertical' => __('Vertical', 'webmatic'),
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'step_number',
            [
                'label' => __('Numéro', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '1',
            ]
        );

        $repeater->add_control(
            'step_title',
            [
                'label' => __('Titre', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Étape 1', 'webmatic'),
            ]
        );

        $repeater->add_control(
            'step_description',
            [
                'label' => __('Description', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Description de l\'étape', 'webmatic'),
                'rows' => 3,
            ]
        );

        $repeater->add_control(
            'step_icon',
            [
                'label' => __('Icône', 'webmatic'),
                'type' => \Elementor\Controls_Manager::ICON,
                'default' => [
                    'value' => 'fas fa-search',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'steps',
            [
                'label' => __('Étapes', 'webmatic'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['step_number' => '1', 'step_title' => __('Contact', 'webmatic'), 'step_description' => __('Vous nous contactez par téléphone ou email pour nous expliquer votre besoin.', 'webmatic'), 'step_icon' => ['value' => 'fas fa-phone']],
                    ['step_number' => '2', 'step_title' => __('Devis', 'webmatic'), 'step_description' => __('Nous étudions votre demande et vous envoyons un devis détaillé sous 24h.', 'webmatic'), 'step_icon' => ['value' => 'fas fa-file-invoice']],
                    ['step_number' => '3', 'step_title' => __('Intervention', 'webmatic'), 'step_description' => __('Après acceptation du devis, nous intervenons selon les modalités convenues.', 'webmatic'), 'step_icon' => ['value' => 'fas fa-tools']],
                    ['step_number' => '4', 'step_title' => __('Suivi', 'webmatic'), 'step_description' => __('Nous assurons le suivi et la garantie de notre intervention.', 'webmatic'), 'step_icon' => ['value' => 'fas fa-check-circle']],
                ],
                'title_field' => '{{{ step_title }}}',
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
                'label' => __('Couleur numéros', 'webmatic'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#4CAF50',
                'selectors' => [
                    '{{WRAPPER}} .step-number' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __('Couleur icônes', 'webmatic'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1e3a5f',
                'selectors' => [
                    '{{WRAPPER}} .step-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $layout_class = 'process-' . $settings['layout'];
        ?>
        <section class="process-section">
            <div class="container">
                <?php if (!empty($settings['section_title'])) : ?>
                    <h2 class="section-title"><?php echo esc_html($settings['section_title']); ?></h2>
                <?php endif; ?>
                
                <div class="process-steps <?php echo esc_attr($layout_class); ?>">
                    <?php foreach ($settings['steps'] as $index => $step) : ?>
                        <div class="step-item">
                            <div class="step-header">
                                <span class="step-number"><?php echo esc_html($step['step_number']); ?></span>
                                <?php if (!empty($step['step_icon']['value'])) : ?>
                                    <div class="step-icon">
                                        <i class="<?php echo esc_attr($step['step_icon']['value']); ?>"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="step-content">
                                <h3 class="step-title"><?php echo esc_html($step['step_title']); ?></h3>
                                <p class="step-description"><?php echo esc_html($step['step_description']); ?></p>
                            </div>
                            <?php if ($index < count($settings['steps']) - 1 && $settings['layout'] === 'horizontal') : ?>
                                <div class="step-connector"></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
