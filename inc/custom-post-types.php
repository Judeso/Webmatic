<?php
/**
 * Custom Post Types pour WebMatic
 * 
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

/**
 * Enregistrement des Custom Post Types
 */
function webmatic_register_post_types() {
    
    // Services
    register_post_type('service', array(
        'labels' => array(
            'name' => __('Services', 'webmatic'),
            'singular_name' => __('Service', 'webmatic'),
            'add_new' => __('Ajouter un service', 'webmatic'),
            'add_new_item' => __('Ajouter un nouveau service', 'webmatic'),
            'edit_item' => __('Modifier le service', 'webmatic'),
            'new_item' => __('Nouveau service', 'webmatic'),
            'view_item' => __('Voir le service', 'webmatic'),
            'search_items' => __('Rechercher des services', 'webmatic'),
            'not_found' => __('Aucun service trouvé', 'webmatic'),
            'menu_name' => __('Services', 'webmatic'),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-admin-tools',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'),
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'services'),
    ));
    
    // Réalisations
    register_post_type('realisation', array(
        'labels' => array(
            'name' => __('Réalisations', 'webmatic'),
            'singular_name' => __('Réalisation', 'webmatic'),
            'add_new' => __('Ajouter une réalisation', 'webmatic'),
            'add_new_item' => __('Ajouter une nouvelle réalisation', 'webmatic'),
            'edit_item' => __('Modifier la réalisation', 'webmatic'),
            'new_item' => __('Nouvelle réalisation', 'webmatic'),
            'view_item' => __('Voir la réalisation', 'webmatic'),
            'search_items' => __('Rechercher des réalisations', 'webmatic'),
            'not_found' => __('Aucune réalisation trouvée', 'webmatic'),
            'menu_name' => __('Réalisations', 'webmatic'),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'realisations'),
    ));
    
    // Témoignages
    register_post_type('testimonial', array(
        'labels' => array(
            'name' => __('Témoignages', 'webmatic'),
            'singular_name' => __('Témoignage', 'webmatic'),
            'add_new' => __('Ajouter un témoignage', 'webmatic'),
            'add_new_item' => __('Ajouter un nouveau témoignage', 'webmatic'),
            'edit_item' => __('Modifier le témoignage', 'webmatic'),
            'new_item' => __('Nouveau témoignage', 'webmatic'),
            'view_item' => __('Voir le témoignage', 'webmatic'),
            'search_items' => __('Rechercher des témoignages', 'webmatic'),
            'not_found' => __('Aucun témoignage trouvé', 'webmatic'),
            'menu_name' => __('Témoignages', 'webmatic'),
        ),
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-star-filled',
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => true,
    ));
    
    // Devis
    register_post_type('devis', array(
        'labels' => array(
            'name' => __('Devis', 'webmatic'),
            'singular_name' => __('Devis', 'webmatic'),
            'add_new' => __('Ajouter un devis', 'webmatic'),
            'edit_item' => __('Modifier le devis', 'webmatic'),
            'view_item' => __('Voir le devis', 'webmatic'),
            'search_items' => __('Rechercher des devis', 'webmatic'),
            'not_found' => __('Aucun devis trouvé', 'webmatic'),
            'menu_name' => __('Devis', 'webmatic'),
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-media-document',
        'supports' => array('title'),
        'show_in_rest' => false,
        'capability_type' => 'post',
        'capabilities' => array(
            'create_posts' => 'do_not_allow',
        ),
        'map_meta_cap' => true,
    ));
}
add_action('init', 'webmatic_register_post_types');

/**
 * Ajouter des meta boxes pour les services
 */
function webmatic_service_meta_boxes() {
    add_meta_box(
        'service_details',
        __('Détails du service', 'webmatic'),
        'webmatic_service_meta_box_callback',
        'service',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'webmatic_service_meta_boxes');

function webmatic_service_meta_box_callback($post) {
    wp_nonce_field('webmatic_service_meta', 'webmatic_service_nonce');
    
    $icon = get_post_meta($post->ID, 'service_icon', true);
    $price = get_post_meta($post->ID, 'service_price', true);
    $features = get_post_meta($post->ID, 'service_features', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="service_icon"><?php _e('Icône (classe Font Awesome)', 'webmatic'); ?></label></th>
            <td>
                <input type="text" id="service_icon" name="service_icon" value="<?php echo esc_attr($icon); ?>" class="regular-text">
                <p class="description"><?php _e('Ex: fas fa-laptop, fas fa-tools, fas fa-gamepad, fas fa-mobile-alt', 'webmatic'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="service_price"><?php _e('Prix (HT)', 'webmatic'); ?></label></th>
            <td>
                <input type="number" id="service_price" name="service_price" value="<?php echo esc_attr($price); ?>" step="0.01" class="regular-text">
                <p class="description"><?php _e('Prix en euros HT', 'webmatic'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="service_features"><?php _e('Caractéristiques', 'webmatic'); ?></label></th>
            <td>
                <textarea id="service_features" name="service_features" rows="5" class="large-text"><?php echo esc_textarea(is_array($features) ? implode("\n", $features) : $features); ?></textarea>
                <p class="description"><?php _e('Une caractéristique par ligne', 'webmatic'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

function webmatic_save_service_meta($post_id) {
    if (!isset($_POST['webmatic_service_nonce']) || !wp_verify_nonce($_POST['webmatic_service_nonce'], 'webmatic_service_meta')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['service_icon'])) {
        update_post_meta($post_id, 'service_icon', sanitize_text_field($_POST['service_icon']));
    }
    
    if (isset($_POST['service_price'])) {
        update_post_meta($post_id, 'service_price', floatval($_POST['service_price']));
    }
    
    if (isset($_POST['service_features'])) {
        $features = explode("\n", sanitize_textarea_field($_POST['service_features']));
        $features = array_map('trim', $features);
        $features = array_filter($features);
        update_post_meta($post_id, 'service_features', $features);
    }
}
add_action('save_post_service', 'webmatic_save_service_meta');

/**
 * Meta boxes pour les réalisations
 */
function webmatic_realisation_meta_boxes() {
    add_meta_box(
        'realisation_details',
        __('Détails de la réalisation', 'webmatic'),
        'webmatic_realisation_meta_box_callback',
        'realisation',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'webmatic_realisation_meta_boxes');

function webmatic_realisation_meta_box_callback($post) {
    wp_nonce_field('webmatic_realisation_meta', 'webmatic_realisation_nonce');
    
    $url = get_post_meta($post->ID, 'realisation_url', true);
    $tags = get_post_meta($post->ID, 'realisation_tags', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="realisation_url"><?php _e('URL du site', 'webmatic'); ?></label></th>
            <td>
                <input type="url" id="realisation_url" name="realisation_url" value="<?php echo esc_url($url); ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th><label for="realisation_tags"><?php _e('Tags', 'webmatic'); ?></label></th>
            <td>
                <input type="text" id="realisation_tags" name="realisation_tags" value="<?php echo esc_attr(is_array($tags) ? implode(', ', $tags) : $tags); ?>" class="regular-text">
                <p class="description"><?php _e('Séparez les tags par des virgules (ex: Site Vitrine, Responsive, Réservation)', 'webmatic'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

function webmatic_save_realisation_meta($post_id) {
    if (!isset($_POST['webmatic_realisation_nonce']) || !wp_verify_nonce($_POST['webmatic_realisation_nonce'], 'webmatic_realisation_meta')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['realisation_url'])) {
        update_post_meta($post_id, 'realisation_url', esc_url_raw($_POST['realisation_url']));
    }
    
    if (isset($_POST['realisation_tags'])) {
        $tags = explode(',', $_POST['realisation_tags']);
        $tags = array_map('trim', $tags);
        $tags = array_filter($tags);
        update_post_meta($post_id, 'realisation_tags', $tags);
    }
}
add_action('save_post_realisation', 'webmatic_save_realisation_meta');

/**
 * Meta boxes pour les témoignages
 */
function webmatic_testimonial_meta_boxes() {
    add_meta_box(
        'testimonial_details',
        __('Détails du témoignage', 'webmatic'),
        'webmatic_testimonial_meta_box_callback',
        'testimonial',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'webmatic_testimonial_meta_boxes');

function webmatic_testimonial_meta_box_callback($post) {
    wp_nonce_field('webmatic_testimonial_meta', 'webmatic_testimonial_nonce');
    
    $rating = get_post_meta($post->ID, 'testimonial_rating', true) ?: 5;
    $author_info = get_post_meta($post->ID, 'testimonial_author_info', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="testimonial_rating"><?php _e('Note', 'webmatic'); ?></label></th>
            <td>
                <select id="testimonial_rating" name="testimonial_rating">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <option value="<?php echo $i; ?>" <?php selected($rating, $i); ?>>
                            <?php echo str_repeat('★', $i); ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="testimonial_author_info"><?php _e('Info auteur', 'webmatic'); ?></label></th>
            <td>
                <input type="text" id="testimonial_author_info" name="testimonial_author_info" value="<?php echo esc_attr($author_info); ?>" class="regular-text">
                <p class="description"><?php _e('Ex: Local Guide · 35 avis', 'webmatic'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

function webmatic_save_testimonial_meta($post_id) {
    if (!isset($_POST['webmatic_testimonial_nonce']) || !wp_verify_nonce($_POST['webmatic_testimonial_nonce'], 'webmatic_testimonial_meta')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['testimonial_rating'])) {
        update_post_meta($post_id, 'testimonial_rating', intval($_POST['testimonial_rating']));
    }
    
    if (isset($_POST['testimonial_author_info'])) {
        update_post_meta($post_id, 'testimonial_author_info', sanitize_text_field($_POST['testimonial_author_info']));
    }
}
add_action('save_post_testimonial', 'webmatic_save_testimonial_meta');

/**
 * Personnaliser les colonnes de la liste des devis
 */
function webmatic_devis_columns($columns) {
    $new_columns = array(
        'cb' => $columns['cb'],
        'title' => __('Numéro', 'webmatic'),
        'client' => __('Client', 'webmatic'),
        'montant' => __('Montant', 'webmatic'),
        'statut' => __('Statut', 'webmatic'),
        'date' => __('Date', 'webmatic'),
    );
    return $new_columns;
}
add_filter('manage_devis_posts_columns', 'webmatic_devis_columns');

function webmatic_devis_column_content($column, $post_id) {
    switch ($column) {
        case 'client':
            $prenom = get_post_meta($post_id, 'devis_prenom', true);
            $nom = get_post_meta($post_id, 'devis_nom', true);
            $email = get_post_meta($post_id, 'devis_email', true);
            echo esc_html($prenom . ' ' . $nom) . '<br>';
            echo '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
            break;
            
        case 'montant':
            $montant = get_post_meta($post_id, 'devis_montant', true);
            echo number_format((float)$montant, 2, ',', ' ') . ' €';
            break;
            
        case 'statut':
            $statut = get_post_meta($post_id, 'devis_statut', true) ?: 'en_attente';
            $statuts = array(
                'en_attente' => __('En attente', 'webmatic'),
                'accepte' => __('Accepté', 'webmatic'),
                'refuse' => __('Refusé', 'webmatic'),
            );
            echo esc_html($statuts[$statut] ?? $statut);
            break;
    }
}
add_action('manage_devis_posts_custom_column', 'webmatic_devis_column_content', 10, 2);