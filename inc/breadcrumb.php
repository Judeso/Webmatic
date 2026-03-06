<?php
/**
 * Breadcrumb (Fil d'Ariane)
 * 
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

/**
 * Afficher le breadcrumb
 */
function webmatic_breadcrumb($args = []) {
    $defaults = [
        'separator' => '<i class="fas fa-chevron-right"></i>',
        'home_text' => __('Accueil', 'webmatic'),
        'show_current' => true,
        'container_class' => 'breadcrumb',
    ];
    $args = wp_parse_args($args, $defaults);
    
    if (is_front_page()) return;
    
    $sep = '<span class="breadcrumb-separator">' . $args['separator'] . '</span>';
    ?>
    <nav class="<?php echo esc_attr($args['container_class']); ?>" aria-label="<?php esc_attr_e('Fil d\'Ariane', 'webmatic'); ?>">
        <div class="container">
            <ol class="breadcrumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                <!-- Accueil -->
                <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="<?php echo esc_url(home_url('/')); ?>" itemprop="item">
                        <span itemprop="name"><?php echo esc_html($args['home_text']); ?></span>
                    </a>
                    <meta itemprop="position" content="1">
                </li>
                
                <?php
                $position = 2;
                
                if (is_category() || is_single()) {
                    // Category
                    $category = get_the_category();
                    if (!empty($category)) {
                        $cat = $category[0];
                        echo $sep;
                        ?>
                        <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" itemprop="item">
                                <span itemprop="name"><?php echo esc_html($cat->name); ?></span>
                            </a>
                            <meta itemprop="position" content="<?php echo $position++; ?>">
                        </li>
                        <?php
                    }
                    
                    // Article
                    if (is_single() && $args['show_current']) {
                        echo $sep;
                        ?>
                        <li class="breadcrumb-item current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <span itemprop="name"><?php the_title(); ?></span>
                            <meta itemprop="position" content="<?php echo $position++; ?>">
                        </li>
                        <?php
                    }
                } elseif (is_page()) {
                    // Page parent
                    if ($post->post_parent) {
                        $parent_id = $post->post_parent;
                        $breadcrumbs = [];
                        
                        while ($parent_id) {
                            $page = get_post($parent_id);
                            $breadcrumbs[] = [
                                'title' => get_the_title($page->ID),
                                'url' => get_permalink($page->ID),
                            ];
                            $parent_id = $page->post_parent;
                        }
                        
                        $breadcrumbs = array_reverse($breadcrumbs);
                        
                        foreach ($breadcrumbs as $crumb) {
                            echo $sep;
                            ?>
                            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                                <a href="<?php echo esc_url($crumb['url']); ?>" itemprop="item">
                                    <span itemprop="name"><?php echo esc_html($crumb['title']); ?></span>
                                </a>
                                <meta itemprop="position" content="<?php echo $position++; ?>">
                            </li>
                            <?php
                        }
                    }
                    
                    // Page actuelle
                    if ($args['show_current']) {
                        echo $sep;
                        ?>
                        <li class="breadcrumb-item current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <span itemprop="name"><?php the_title(); ?></span>
                            <meta itemprop="position" content="<?php echo $position++; ?>">
                        </li>
                        <?php
                    }
                } elseif (is_archive()) {
                    // Archives
                    echo $sep;
                    ?>
                    <li class="breadcrumb-item current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <span itemprop="name"><?php single_cat_title(); ?></span>
                        <meta itemprop="position" content="<?php echo $position++; ?>">
                    </li>
                    <?php
                } elseif (is_search()) {
                    // Recherche
                    echo $sep;
                    ?>
                    <li class="breadcrumb-item current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <span itemprop="name"><?php printf(__('Recherche: %s', 'webmatic'), get_search_query()); ?></span>
                        <meta itemprop="position" content="<?php echo $position++; ?>">
                    </li>
                    <?php
                } elseif (is_404()) {
                    // 404
                    echo $sep;
                    ?>
                    <li class="breadcrumb-item current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <span itemprop="name"><?php _e('Page non trouvée', 'webmatic'); ?></span>
                        <meta itemprop="position" content="<?php echo $position++; ?>">
                    </li>
                    <?php
                }
                ?>
            </ol>
        </div>
    </nav>
    <?php
}

/**
 * Shortcode breadcrumb
 */
function webmatic_breadcrumb_shortcode($atts) {
    ob_start();
    webmatic_breadcrumb($atts);
    return ob_get_clean();
}
add_shortcode('webmatic_breadcrumb', 'webmatic_breadcrumb_shortcode');

/**
 * Afficher automatiquement le breadcrumb (option Customizer)
 */
function webmatic_auto_breadcrumb() {
    $enabled = get_theme_mod('webmatic_show_breadcrumb', true);
    if (!$enabled) return;
    if (is_front_page()) return;
    
    webmatic_breadcrumb();
}
add_action('webmatic_before_main_content', 'webmatic_auto_breadcrumb', 5);

/**
 * Hook pour placer le breadcrumb
 */
function webmatic_breadcrumb_hook() {
    do_action('webmatic_before_main_content');
}

/**
 * Option Customizer
 */
function webmatic_breadcrumb_customizer($wp_customize) {
    $wp_customize->add_setting('webmatic_show_breadcrumb', [
        'default' => true,
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_control('webmatic_show_breadcrumb', [
        'label' => __('Afficher le fil d\'Ariane', 'webmatic'),
        'section' => 'webmatic_homepage',
        'type' => 'checkbox',
    ]);
}
add_action('customize_register', 'webmatic_breadcrumb_customizer');
