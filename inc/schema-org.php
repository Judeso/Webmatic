<?php
/**
 * Schema.org Markup (Rich Snippets)
 * 
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

/**
 * Schema.org Local Business
 */
function webmatic_schema_local_business() {
    if (!is_front_page()) return;
    
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => get_bloginfo('name'),
        'description' => get_bloginfo('description'),
        'url' => home_url(),
        'telephone' => get_theme_mod('webmatic_phone', '07 56 91 30 61'),
        'email' => get_theme_mod('webmatic_email', 'contact@web-matic.fr'),
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => get_theme_mod('webmatic_street', ''),
            'addressLocality' => get_theme_mod('webmatic_city', 'Pommier'),
            'postalCode' => get_theme_mod('webmatic_postal', '69480'),
            'addressCountry' => 'FR',
        ],
        'geo' => [
            '@type' => 'GeoCoordinates',
            'latitude' => get_theme_mod('webmatic_latitude', '45.985'),
            'longitude' => get_theme_mod('webmatic_longitude', '4.633'),
        ],
        'openingHoursSpecification' => [
            [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'opens' => '09:00',
                'closes' => '18:00',
            ],
        ],
        'priceRange' => '€€',
        'areaServed' => [
            '@type' => 'City',
            'name' => 'Lyon et région Rhône-Alpes',
        ],
        'hasOfferCatalog' => [
            '@type' => 'OfferCatalog',
            'name' => 'Services informatiques',
            'itemListElement' => [
                [
                    '@type' => 'Offer',
                    'itemOffered' => [
                        '@type' => 'Service',
                        'name' => 'Développement Web',
                    ],
                ],
                [
                    '@type' => 'Offer',
                    'itemOffered' => [
                        '@type' => 'Service',
                        'name' => 'Maintenance Informatique',
                    ],
                ],
            ],
        ],
    ];
    
    // Logo
    $custom_logo_id = get_theme_mod('custom_logo');
    if ($custom_logo_id) {
        $logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
        if ($logo_url) {
            $schema['logo'] = $logo_url;
            $schema['image'] = $logo_url;
        }
    }
    
    // Social links
    $same_as = [];
    if (get_theme_mod('webmatic_facebook')) $same_as[] = get_theme_mod('webmatic_facebook');
    if (get_theme_mod('webmatic_twitter')) $same_as[] = get_theme_mod('webmatic_twitter');
    if (get_theme_mod('webmatic_linkedin')) $same_as[] = get_theme_mod('webmatic_linkedin');
    if (!empty($same_as)) {
        $schema['sameAs'] = $same_as;
    }
    
    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE) . '</script>';
}
add_action('wp_footer', 'webmatic_schema_local_business', 1);

/**
 * Schema.org Article pour les posts
 */
function webmatic_schema_article() {
    if (!is_singular('post')) return;
    
    global $post;
    
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => get_the_title(),
        'description' => get_the_excerpt(),
        'author' => [
            '@type' => 'Person',
            'name' => get_the_author(),
            'url' => get_author_posts_url(get_the_author_meta('ID')),
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => get_bloginfo('name'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => get_theme_mod('custom_logo') ? wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full') : '',
            ],
        ],
        'datePublished' => get_the_date('c'),
        'dateModified' => get_the_modified_date('c'),
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => get_permalink(),
        ],
    ];
    
    // Image
    if (has_post_thumbnail()) {
        $schema['image'] = [
            '@type' => 'ImageObject',
            'url' => get_the_post_thumbnail_url(null, 'large'),
            'width' => 1200,
            'height' => 630,
        ];
    }
    
    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE) . '</script>';
}
add_action('wp_footer', 'webmatic_schema_article', 2);

/**
 * Schema.org BreadcrumbList
 */
function webmatic_schema_breadcrumb() {
    if (is_front_page()) return;
    
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => __('Accueil', 'webmatic'),
                'item' => home_url(),
            ],
        ],
    ];
    
    $position = 2;
    
    if (is_category()) {
        $schema['itemListElement'][] = [
            '@type' => 'ListItem',
            'position' => $position,
            'name' => single_cat_title('', false),
            'item' => get_category_link(get_query_var('cat')),
        ];
    } elseif (is_single()) {
        $category = get_the_category();
        if (!empty($category)) {
            $schema['itemListElement'][] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $category[0]->name,
                'item' => get_category_link($category[0]->term_id),
            ];
        }
        $schema['itemListElement'][] = [
            '@type' => 'ListItem',
            'position' => $position,
            'name' => get_the_title(),
            'item' => get_permalink(),
        ];
    } elseif (is_page()) {
        global $post;
        if ($post->post_parent) {
            $parent = get_post($post->post_parent);
            $schema['itemListElement'][] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => get_the_title($parent->ID),
                'item' => get_permalink($parent->ID),
            ];
        }
        $schema['itemListElement'][] = [
            '@type' => 'ListItem',
            'position' => $position,
            'name' => get_the_title(),
            'item' => get_permalink(),
        ];
    }
    
    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE) . '</script>';
}
add_action('wp_footer', 'webmatic_schema_breadcrumb', 3);

/**
 * Schema.org Website
 */
function webmatic_schema_website() {
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => get_bloginfo('name'),
        'url' => home_url(),
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => home_url('/?s={search_term_string}'),
            'query-input' => 'required name=search_term_string',
        ],
    ];
    
    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE) . '</script>';
}
add_action('wp_footer', 'webmatic_schema_website', 4);
