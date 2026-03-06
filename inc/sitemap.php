<?php
/**
 * Sitemap XML Automatique
 * 
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

/**
 * Générer le sitemap XML
 */
function webmatic_generate_sitemap() {
    $posts_per_page = 1000;
    
    header('Content-Type: application/xml; charset=UTF-8');
    
    echo '<?xml version="1.0" encoding="UTF-8"?>';
    ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    
    <!-- Homepage -->
    <url>
        <loc><?php echo esc_url(home_url('/')); ?></loc>
        <lastmod><?php echo date('c'); ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    
    <?php
    // Pages
    $pages = get_posts([
        'post_type' => 'page',
        'posts_per_page' => $posts_per_page,
        'post_status' => 'publish',
    ]);
    
    foreach ($pages as $page) :
        $priority = ($page->ID == get_option('page_on_front')) ? '1.0' : '0.8';
        $changefreq = 'weekly';
    ?>
    <url>
        <loc><?php echo esc_url(get_permalink($page)); ?></loc>
        <lastmod><?php echo date('c', strtotime($page->post_modified)); ?></lastmod>
        <changefreq><?php echo $changefreq; ?></changefreq>
        <priority><?php echo $priority; ?></priority>
        <?php if (has_post_thumbnail($page->ID)) : ?>
        <image:image>
            <image:loc><?php echo esc_url(get_the_post_thumbnail_url($page->ID, 'full')); ?></image:loc>
            <image:title><?php echo esc_xml(get_the_title($page->ID)); ?></image:title>
        </image:image>
        <?php endif; ?>
    </url>
    <?php endforeach; ?>
    
    <?php
    // Articles
    $posts = get_posts([
        'post_type' => 'post',
        'posts_per_page' => $posts_per_page,
        'post_status' => 'publish',
    ]);
    
    foreach ($posts as $post) :
    ?>
    <url>
        <loc><?php echo esc_url(get_permalink($post)); ?></loc>
        <lastmod><?php echo date('c', strtotime($post->post_modified)); ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
        <?php if (has_post_thumbnail($post->ID)) : ?>
        <image:image>
            <image:loc><?php echo esc_url(get_the_post_thumbnail_url($post->ID, 'full')); ?></image:loc>
            <image:title><?php echo esc_xml(get_the_title($post->ID)); ?></image:title>
        </image:image>
        <?php endif; ?>
    </url>
    <?php endforeach; ?>
    
    <?php
    // Services
    $services = get_posts([
        'post_type' => 'service',
        'posts_per_page' => $posts_per_page,
        'post_status' => 'publish',
    ]);
    
    foreach ($services as $service) :
    ?>
    <url>
        <loc><?php echo esc_url(get_permalink($service)); ?></loc>
        <lastmod><?php echo date('c', strtotime($service->post_modified)); ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
        <?php if (has_post_thumbnail($service->ID)) : ?>
        <image:image>
            <image:loc><?php echo esc_url(get_the_post_thumbnail_url($service->ID, 'full')); ?></image:loc>
            <image:title><?php echo esc_xml(get_the_title($service->ID)); ?></image:title>
        </image:image>
        <?php endif; ?>
    </url>
    <?php endforeach; ?>
    
    <?php
    // Réalisations
    $realisations = get_posts([
        'post_type' => 'realisation',
        'posts_per_page' => $posts_per_page,
        'post_status' => 'publish',
    ]);
    
    foreach ($realisations as $realisation) :
    ?>
    <url>
        <loc><?php echo esc_url(get_permalink($realisation)); ?></loc>
        <lastmod><?php echo date('c', strtotime($realisation->post_modified)); ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
        <?php if (has_post_thumbnail($realisation->ID)) : ?>
        <image:image>
            <image:loc><?php echo esc_url(get_the_post_thumbnail_url($realisation->ID, 'full')); ?></image:loc>
            <image:title><?php echo esc_xml(get_the_title($realisation->ID)); ?></image:title>
        </image:image>
        <?php endif; ?>
    </url>
    <?php endforeach; ?>
    
    <?php
    // Categories
    $categories = get_categories(['hide_empty' => true]);
    foreach ($categories as $cat) :
    ?>
    <url>
        <loc><?php echo esc_url(get_category_link($cat->term_id)); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.5</priority>
    </url>
    <?php endforeach; ?>
    
</urlset>
    <?php
    exit;
}

/**
 * Endpoint rewrite rule pour le sitemap
 */
function webmatic_sitemap_rewrite_rule() {
    add_rewrite_rule('sitemap\.xml$', 'index.php?webmatic_sitemap=1', 'top');
}
add_action('init', 'webmatic_sitemap_rewrite_rule');

/**
 * Query var pour le sitemap
 */
function webmatic_sitemap_query_var($vars) {
    $vars[] = 'webmatic_sitemap';
    return $vars;
}
add_filter('query_vars', 'webmatic_sitemap_query_var');

/**
 * Générer le sitemap quand le query var est présent
 */
function webmatic_sitemap_template_redirect() {
    if (get_query_var('webmatic_sitemap')) {
        webmatic_generate_sitemap();
    }
}
add_action('template_redirect', 'webmatic_sitemap_template_redirect');

/**
 * Ajouter le sitemap dans robots.txt
 */
function webmatic_robots_txt($output) {
    $output .= "Sitemap: " . home_url('/sitemap.xml') . "\n";
    return $output;
}
add_filter('robots_txt', 'webmatic_robots_txt');

/**
 * Notifier les moteurs de recherche quand le contenu change
 */
function webmatic_ping_search_engines($post_id) {
    // Ne pas pinger pour les révisions ou autosaves
    if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) return;
    
    $sitemap_url = urlencode(home_url('/sitemap.xml'));
    
    // Ping Google
    wp_remote_get("http://www.google.com/ping?sitemap={$sitemap_url}", ['timeout' => 3]);
    
    // Ping Bing
    wp_remote_get("http://www.bing.com/ping?sitemap={$sitemap_url}", ['timeout' => 3]);
}
add_action('publish_post', 'webmatic_ping_search_engines');
add_action('publish_page', 'webmatic_ping_search_engines');
add_action('publish_service', 'webmatic_ping_search_engines');
add_action('publish_realisation', 'webmatic_ping_search_engines');
