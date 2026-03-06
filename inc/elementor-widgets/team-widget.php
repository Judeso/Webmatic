<?php
/**
 * Widget Team/Membre pour Elementor
 *
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

class Webmatic_Team_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'webmatic_team';
    }

    public function get_title() {
        return __('Équipe / Membres', 'webmatic');
    }

    public function get_icon() {
        return 'eicon-person';
    }

    public function get_categories() {
        return ['webmatic'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Membres', 'webmatic'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label' => __('Titre de section', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Notre Équipe', 'webmatic'),
                'label_block' => true,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'member_name',
            [
                'label' => __('Nom', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Audric L.', 'webmatic'),
            ]
        );

        $repeater->add_control(
            'member_role',
            [
                'label' => __('Rôle / Poste', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Fondateur & Développeur', 'webmatic'),
            ]
        );

        $repeater->add_control(
            'member_photo',
            [
                'label' => __('Photo', 'webmatic'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        $repeater->add_control(
            'member_bio',
            [
                'label' => __('Bio', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Passionné par le web et l\'informatique depuis plus de 10 ans.', 'webmatic'),
                'rows' => 3,
            ]
        );

        $repeater->add_control(
            'member_email',
            [
                'label' => __('Email', 'webmatic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
            ]
        );

        $repeater->add_control(
            'member_linkedin',
            [
                'label' => __('LinkedIn', 'webmatic'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [],
                'placeholder' => __('https://linkedin.com/in/...', 'webmatic'),
            ]
        );

        $repeater->add_control(
            'member_twitter',
            [
                'label' => __('Twitter/X', 'webmatic'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [],
                'placeholder' => __('https://twitter.com/...', 'webmatic'),
            ]
        );

        $this->add_control(
            'team_members',
            [
                'label' => __('Membres', 'webmatic'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'member_name' => __('Audric L.', 'webmatic'),
                        'member_role' => __('Fondateur & Développeur', 'webmatic'),
                        'member_bio' => __('Passionné par le web et l\'informatique depuis plus de 10 ans. Expert WordPress et développeur full-stack.', 'webmatic'),
                    ],
                ],
                'title_field' => '{{{ member_name }}}',
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => __('Colonnes', 'webmatic'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
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
            'card_bg',
            [
                'label' => __('Fond cartes', 'webmatic'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .team-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __('Couleur texte', 'webmatic'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .team-card' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $columns = 'team-grid-' . $settings['columns'];
        ?>
        <section class="team-section">
            <div class="container">
                <?php if (!empty($settings['section_title'])) : ?>
                    <h2 class="section-title"><?php echo esc_html($settings['section_title']); ?></h2>
                <?php endif; ?>
                
                <div class="team-grid <?php echo esc_attr($columns); ?>">
                    <?php foreach ($settings['team_members'] as $member) : ?>
                        <div class="team-card">
                            <?php if (!empty($member['member_photo']['url'])) : ?>
                                <div class="team-photo">
                                    <img src="<?php echo esc_url($member['member_photo']['url']); ?>" 
                                         alt="<?php echo esc_attr($member['member_name']); ?>"
                                         loading="lazy">
                                </div>
                            <?php else : ?>
                                <div class="team-photo team-photo-placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                            <?php endif; ?>
                            
                            <h3 class="team-name"><?php echo esc_html($member['member_name']); ?></h3>
                            <p class="team-role"><?php echo esc_html($member['member_role']); ?></p>
                            
                            <?php if (!empty($member['member_bio'])) : ?>
                                <p class="team-bio"><?php echo esc_html($member['member_bio']); ?></p>
                            <?php endif; ?>
                            
                            <div class="team-social">
                                <?php if (!empty($member['member_email'])) : ?>
                                    <a href="mailto:<?php echo esc_attr($member['member_email']); ?>" aria-label="Email">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (!empty($member['member_linkedin']['url'])) : ?>
                                    <a href="<?php echo esc_url($member['member_linkedin']['url']); ?>" target="_blank" rel="noopener" aria-label="LinkedIn">
                                        <i class="fab fa-linkedin"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (!empty($member['member_twitter']['url'])) : ?>
                                    <a href="<?php echo esc_url($member['member_twitter']['url']); ?>" target="_blank" rel="noopener" aria-label="Twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}
