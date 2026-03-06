<?php
/**
 * Widget FAQ Accordion pour Elementor
 *
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

class Webmatic_FAQ_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'webmatic_faq';
    }

    public function get_title() {
        return __('FAQ Accordion', 'webmatic');
    }

    public function get_icon() {
        return 'eicon-accordion';
    }

    public function get_categories() {
        return ['webmatic'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Questions / Réponses', 'webmatic'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label' => __('Titre de section', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Questions fréquentes', 'webmatic'),
                'label_block' => true,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'question',
            [
                'label' => __('Question', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Quels sont vos délais d\'intervention ?', 'webmatic'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'answer',
            [
                'label' => __('Réponse', 'webmatic'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __('Nous intervenons généralement sous 24 à 48h pour les demandes urgentes. Pour les projets de création web, le délai dépend de la complexité et varie de 1 à 4 semaines.', 'webmatic'),
            ]
        );

        $repeater->add_control(
            'icon',
            [
                'label' => __('Icône', 'webmatic'),
                'type' => \Elementor\Controls_Manager::ICON,
                'default' => [
                    'value' => 'fas fa-plus',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'faq_items',
            [
                'label' => __('FAQ Items', 'webmatic'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'question' => __('Quels sont vos délais d\'intervention ?', 'webmatic'),
                        'answer' => __('Nous intervenons généralement sous 24 à 48h pour les demandes urgentes. Pour les projets de création web, le délai dépend de la complexité et varie de 1 à 4 semaines.', 'webmatic'),
                    ],
                    [
                        'question' => __('Proposez-vous des garanties sur vos interventions ?', 'webmatic'),
                        'answer' => __('Oui, toutes nos interventions informatiques sont garanties 3 mois. Pour les sites web, nous offrons une garantie de fonctionnement de 6 mois incluse.', 'webmatic'),
                    ],
                    [
                        'question' => __('Comment se déroule la création d\'un site web ?', 'webmatic'),
                        'answer' => __('Nous commençons par un échange pour comprendre vos besoins, puis nous élaborons une proposition détaillée. Après validation, nous créons des maquettes, développons le site, et vous formons à son utilisation.', 'webmatic'),
                    ],
                ],
                'title_field' => '{{{ question }}}',
            ]
        );

        $this->add_control(
            'faq_schema',
            [
                'label' => __('Ajouter Schema.org FAQ', 'webmatic'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'description' => __('Améliore le SEO avec les rich snippets Google', 'webmatic'),
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
            'question_bg',
            [
                'label' => __('Fond questions', 'webmatic'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f8f9fa',
                'selectors' => [
                    '{{WRAPPER}} .faq-question' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'question_color',
            [
                'label' => __('Couleur questions', 'webmatic'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1e3a5f',
                'selectors' => [
                    '{{WRAPPER}} .faq-question' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __('Couleur icône', 'webmatic'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#4CAF50',
                'selectors' => [
                    '{{WRAPPER}} .faq-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $faq_schema = [];
        ?>
        <section class="faq-section" <?php if ($settings['faq_schema'] === 'yes') echo 'itemscope itemtype="https://schema.org/FAQPage"'; ?>>
            <div class="container">
                <?php if (!empty($settings['section_title'])) : ?>
                    <h2 class="faq-section-title"><?php echo esc_html($settings['section_title']); ?></h2>
                <?php endif; ?>
                
                <div class="faq-list">
                    <?php foreach ($settings['faq_items'] as $index => $item) : 
                        if ($settings['faq_schema'] === 'yes') {
                            $faq_schema[] = [
                                '@type' => 'Question',
                                'name' => $item['question'],
                                'acceptedAnswer' => [
                                    '@type' => 'Answer',
                                    'text' => wp_strip_all_tags($item['answer']),
                                ],
                            ];
                        }
                    ?>
                        <div class="faq-item" <?php if ($settings['faq_schema'] === 'yes') echo 'itemscope itemprop="mainEntity" itemtype="https://schema.org/Question"'; ?>>
                            <button class="faq-question" aria-expanded="false" aria-controls="faq-answer-<?php echo $index; ?>">
                                <span class="faq-question-text" <?php if ($settings['faq_schema'] === 'yes') echo 'itemprop="name"'; ?>><?php echo esc_html($item['question']); ?></span>
                                <span class="faq-icon">
                                    <?php if (!empty($item['icon']['value'])) : ?>
                                        <i class="<?php echo esc_attr($item['icon']['value']); ?>"></i>
                                    <?php else : ?>
                                        <i class="fas fa-plus"></i>
                                    <?php endif; ?>
                                </span>
                            </button>
                            <div id="faq-answer-<?php echo $index; ?>" class="faq-answer" <?php if ($settings['faq_schema'] === 'yes') echo 'itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"'; ?> hidden>
                                <div class="faq-answer-content" <?php if ($settings['faq_schema'] === 'yes') echo 'itemprop="text"'; ?>>
                                    <?php echo wp_kses_post($item['answer']); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        
        <?php if ($settings['faq_schema'] === 'yes' && !empty($faq_schema)) : ?>
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": <?php echo json_encode($faq_schema, JSON_UNESCAPED_UNICODE); ?>
        }
        </script>
        <?php endif; ?>
        <?php
    }
}
