<?php
/**
 * Widget Pricing Table pour Elementor
 *
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

class Webmatic_Pricing_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'webmatic_pricing';
    }

    public function get_title() {
        return __('Table de Prix', 'webmatic');
    }

    public function get_icon() {
        return 'eicon-price-table';
    }

    public function get_categories() {
        return ['webmatic'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Forfaits', 'webmatic'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'package_name',
            [
                'label' => __('Nom du forfait', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Site Vitrine', 'webmatic'),
            ]
        );

        $repeater->add_control(
            'package_price',
            [
                'label' => __('Prix', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '990€',
            ]
        );

        $repeater->add_control(
            'package_period',
            [
                'label' => __('Période', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('à partir de', 'webmatic'),
                'placeholder' => __('à partir de, /mois, etc.', 'webmatic'),
            ]
        );

        $repeater->add_control(
            'package_description',
            [
                'label' => __('Description', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Idéal pour présenter votre activité', 'webmatic'),
            ]
        );

        $repeater->add_control(
            'package_features',
            [
                'label' => __('Fonctionnalités (une par ligne)', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => "Site responsive\n5 pages incluses\nFormulaire de contact\nOptimisation SEO",
                'rows' => 5,
            ]
        );

        $repeater->add_control(
            'package_button_text',
            [
                'label' => __('Texte du bouton', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Demander un devis', 'webmatic'),
            ]
        );

        $repeater->add_control(
            'package_button_url',
            [
                'label' => __('URL du bouton', 'webmatic'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [
                    'url' => get_permalink(get_theme_mod('webmatic_devis_page', '')),
                ],
            ]
        );

        $repeater->add_control(
            'package_highlighted',
            [
                'label' => __('Forfait recommandé', 'webmatic'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );

        $repeater->add_control(
            'package_badge',
            [
                'label' => __('Badge', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Populaire', 'webmatic'),
                'condition' => [
                    'package_highlighted' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pricing_items',
            [
                'label' => __('Forfaits', 'webmatic'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'package_name' => __('Site Vitrine', 'webmatic'),
                        'package_price' => '990€',
                        'package_period' => __('à partir de', 'webmatic'),
                        'package_description' => __('Présentez votre activité en ligne', 'webmatic'),
                        'package_features' => "Site responsive\n5 pages incluses\nFormulaire de contact\nOptimisation SEO",
                        'package_button_text' => __('Demander un devis', 'webmatic'),
                        'package_highlighted' => '',
                    ],
                    [
                        'package_name' => __('E-Commerce', 'webmatic'),
                        'package_price' => '2490€',
                        'package_period' => __('à partir de', 'webmatic'),
                        'package_description' => __('Vendez vos produits en ligne', 'webmatic'),
                        'package_features' => "Site vitrine +\nBoutique en ligne\nPaiement sécurisé\nGestion des stocks\nFormation incluse",
                        'package_button_text' => __('Demander un devis', 'webmatic'),
                        'package_highlighted' => 'yes',
                        'package_badge' => __('Populaire', 'webmatic'),
                    ],
                    [
                        'package_name' => __('Sur Mesure', 'webmatic'),
                        'package_price' => 'Sur devis',
                        'package_period' => '',
                        'package_description' => __('Solution personnalisée adaptée à vos besoins', 'webmatic'),
                        'package_features' => "Développement spécifique\nIntégrations API\nApplications web\nMaintenance incluse",
                        'package_button_text' => __('Nous contacter', 'webmatic'),
                        'package_highlighted' => '',
                    ],
                ],
                'title_field' => '{{{ package_name }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="pricing-section">
            <div class="container">
                <div class="pricing-grid">
                    <?php foreach ($settings['pricing_items'] as $item) : 
                        $highlighted = $item['package_highlighted'] === 'yes' ? 'pricing-card-highlighted' : '';
                    ?>
                        <div class="pricing-card <?php echo esc_attr($highlighted); ?>">
                            <?php if ($item['package_highlighted'] === 'yes' && !empty($item['package_badge'])) : ?>
                                <span class="pricing-badge"><?php echo esc_html($item['package_badge']); ?></span>
                            <?php endif; ?>
                            
                            <h3 class="pricing-name"><?php echo esc_html($item['package_name']); ?></h3>
                            
                            <div class="pricing-price-wrapper">
                                <span class="pricing-price"><?php echo esc_html($item['package_price']); ?></span>
                                <?php if (!empty($item['package_period'])) : ?>
                                    <span class="pricing-period"><?php echo esc_html($item['package_period']); ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <p class="pricing-description"><?php echo esc_html($item['package_description']); ?></p>
                            
                            <?php if (!empty($item['package_features'])) : 
                                $features = explode("\n", $item['package_features']);
                            ?>
                                <ul class="pricing-features">
                                    <?php foreach ($features as $feature) : 
                                        $feature = trim($feature);
                                        if (!empty($feature)) : 
                                            // Check if feature is excluded (starts with -)
                                            $is_excluded = strpos($feature, '-') === 0;
                                            $icon_class = $is_excluded ? 'fa-times' : 'fa-check';
                                            $feature_text = $is_excluded ? ltrim($feature, '- ') : $feature;
                                    ?>
                                        <li class="<?php echo $is_excluded ? 'excluded' : ''; ?>">
                                            <i class="fas <?php echo esc_attr($icon_class); ?>"></i>
                                            <?php echo esc_html($feature_text); ?>
                                        </li>
                                    <?php endif; endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            
                            <?php if (!empty($item['package_button_url']['url'])) : ?>
                                <a href="<?php echo esc_url($item['package_button_url']['url']); ?>" 
                                   class="btn btn-pricing"
                                   <?php if ($item['package_button_url']['is_external']) echo 'target="_blank" rel="noopener noreferrer"'; ?>>
                                    <?php echo esc_html($item['package_button_text']); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
