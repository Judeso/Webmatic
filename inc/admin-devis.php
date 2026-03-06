<?php
/**
 * Gestion des devis en administration
 * 
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

/**
 * Traitement Ajax pour soumettre un devis
 */
function webmatic_submit_devis() {
    check_ajax_referer('webmatic_devis_nonce', 'nonce');
    
    // Récupérer les données POST
    $data = $_POST;
    
    // Valider les données
    $required_fields = array('prenom', 'nom', 'email', 'telephone', 'adresse', 'code_postal', 'ville');
    foreach ($required_fields as $field) {
        if (empty($data[$field])) {
            wp_send_json_error(array('message' => sprintf(__('Le champ %s est obligatoire.', 'webmatic'), $field)));
        }
    }
    
    if (!is_email($data['email'])) {
        wp_send_json_error(array('message' => __('Adresse email invalide.', 'webmatic')));
    }
    
    // Générer le numéro de devis
    $year = date('Y');
    $last_devis = get_posts(array(
        'post_type' => 'devis',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'DESC',
        'meta_key' => 'devis_year',
        'meta_value' => $year,
    ));
    
    $counter = 1;
    if (!empty($last_devis)) {
        $last_number = get_post_meta($last_devis[0]->ID, 'devis_counter', true);
        $counter = intval($last_number) + 1;
    }
    
    $devis_number = sprintf('DEVIS-%s-%02d-%04d', $year, date('m'), $counter);
    
    // Calculer le montant total
    $services = json_decode(stripslashes($data['services']), true);
    $montant_total = 0;
    foreach ($services as $service) {
        $montant_total += floatval($service['price']) * intval($service['quantity']);
    }
    
    // Créer le devis
    $post_id = wp_insert_post(array(
        'post_title' => $devis_number,
        'post_type' => 'devis',
        'post_status' => 'publish',
    ));
    
    if (is_wp_error($post_id)) {
        wp_send_json_error(array('message' => __('Erreur lors de la création du devis.', 'webmatic')));
    }
    
    // Sauvegarder les métadonnées
    $meta_data = array(
        'devis_number' => $devis_number,
        'devis_year' => $year,
        'devis_counter' => $counter,
        'devis_prenom' => sanitize_text_field($data['prenom']),
        'devis_nom' => sanitize_text_field($data['nom']),
        'devis_email' => sanitize_email($data['email']),
        'devis_telephone' => sanitize_text_field($data['telephone']),
        'devis_adresse' => sanitize_text_field($data['adresse']),
        'devis_code_postal' => sanitize_text_field($data['code_postal']),
        'devis_ville' => sanitize_text_field($data['ville']),
        'devis_type_client' => sanitize_text_field($data['type_client'] ?? 'particulier'),
        'devis_nom_entreprise' => sanitize_text_field($data['nom_entreprise'] ?? ''),
        'devis_siret' => sanitize_text_field($data['siret'] ?? ''),
        'devis_services' => $services,
        'devis_montant' => $montant_total,
        'devis_statut' => 'en_attente',
    );
    
    foreach ($meta_data as $key => $value) {
        update_post_meta($post_id, $key, $value);
    }
    
    // Envoyer l'email au client
    $client_email = sanitize_email($data['email']);
    $client_name = sanitize_text_field($data['prenom'] . ' ' . $data['nom']);
    
    $subject = sprintf(__('[WebMatic] Votre devis %s', 'webmatic'), $devis_number);
    
    $message = sprintf(
        __(
            "Bonjour %s,\n\n" .
            "Merci d'avoir utilisé notre générateur de devis.\n\n" .
            "Votre devis numéro %s a été généré avec succès.\n\n" .
            "Montant total: %.2f € HT\n\n" .
            "Détail des services:\n%s\n\n" .
            "Nous vous contacterons dans les plus brefs délais.\n\n" .
            "Cordialement,\n" .
            "L'équipe WebMatic\n" .
            "Tél: %s\n" .
            "Email: %s",
            'webmatic'
        ),
        $client_name,
        $devis_number,
        $montant_total,
        webmatic_format_services_list($services),
        get_theme_mod('webmatic_phone', '07 56 91 30 61'),
        get_theme_mod('webmatic_email', 'contact@web-matic.fr')
    );
    
    $headers = array('Content-Type: text/plain; charset=UTF-8');
    wp_mail($client_email, $subject, $message, $headers);
    
    // Envoyer l'email à l'administrateur
    $admin_email = get_theme_mod('webmatic_email', get_option('admin_email'));
    $admin_subject = sprintf(__('[WebMatic] Nouveau devis %s', 'webmatic'), $devis_number);
    
    $admin_message = sprintf(
        __(
            "Nouveau devis reçu:\n\n" .
            "Numéro: %s\n" .
            "Client: %s\n" .
            "Email: %s\n" .
            "Téléphone: %s\n" .
            "Adresse: %s, %s %s\n\n" .
            "Type: %s\n" .
            "Montant total: %.2f € HT\n\n" .
            "Services demandés:\n%s\n\n" .
            "Voir le devis dans l'admin: %s",
            'webmatic'
        ),
        $devis_number,
        $client_name,
        $client_email,
        $data['telephone'],
        $data['adresse'],
        $data['code_postal'],
        $data['ville'],
        $data['type_client'],
        $montant_total,
        webmatic_format_services_list($services),
        admin_url('post.php?post=' . $post_id . '&action=edit')
    );
    
    wp_mail($admin_email, $admin_subject, $admin_message, $headers);
    
    wp_send_json_success(array(
        'message' => __('Devis envoyé avec succès !', 'webmatic'),
        'devis_number' => $devis_number,
        'montant' => number_format($montant_total, 2, ',', ' ') . ' €',
    ));
}
add_action('wp_ajax_webmatic_submit_devis', 'webmatic_submit_devis');
add_action('wp_ajax_nopriv_webmatic_submit_devis', 'webmatic_submit_devis');

/**
 * Formater la liste des services pour l'email
 */
function webmatic_format_services_list($services) {
    $list = '';
    foreach ($services as $service) {
        $list .= sprintf(
            "- %s x%d: %.2f €\n",
            $service['name'],
            $service['quantity'],
            $service['price'] * $service['quantity']
        );
    }
    return $list;
}

/**
 * Récupérer les services disponibles via Ajax
 */
function webmatic_get_services() {
    $services = array();
    
    // Essayer de récupérer les services personnalisés
    $query = new WP_Query(array(
        'post_type' => 'service',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
    ));
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $service_id = get_the_ID();
            $price = get_post_meta($service_id, 'service_price', true);
            
            if ($price) {
                $services[] = array(
                    'id' => $service_id,
                    'name' => get_the_title(),
                    'description' => get_the_excerpt(),
                    'price' => floatval($price),
                    'category' => get_post_meta($service_id, 'service_category', true) ?: 'general',
                );
            }
        }
        wp_reset_postdata();
    }
    
    // Si aucun service personnalisé, utiliser les services par défaut
    if (empty($services)) {
        $services = webmatic_get_default_services();
    }
    
    wp_send_json_success($services);
}
add_action('wp_ajax_webmatic_get_services', 'webmatic_get_services');
add_action('wp_ajax_nopriv_webmatic_get_services', 'webmatic_get_services');

/**
 * Services par défaut
 */
function webmatic_get_default_services() {
    return array(
        array('id' => 1, 'name' => 'Site vitrine', 'price' => 450, 'category' => 'web'),
        array('id' => 2, 'name' => 'Site e-commerce', 'price' => 890, 'category' => 'web'),
        array('id' => 3, 'name' => 'Refonte site', 'price' => 320, 'category' => 'web'),
        array('id' => 4, 'name' => 'Montage PC', 'price' => 95, 'category' => 'maintenance'),
        array('id' => 5, 'name' => 'Intervention', 'price' => 75, 'category' => 'maintenance'),
        array('id' => 6, 'name' => 'Nettoyage PC', 'price' => 65, 'category' => 'maintenance'),
        array('id' => 7, 'name' => 'Installation caméra', 'price' => 85, 'category' => 'securite'),
        array('id' => 8, 'name' => 'Config NVR', 'price' => 110, 'category' => 'securite'),
        array('id' => 9, 'name' => 'Pack 2 caméras', 'price' => 280, 'category' => 'securite'),
        array('id' => 10, 'name' => 'Réparation écran', 'price' => 65, 'category' => 'mobile'),
        array('id' => 11, 'name' => 'Changement batterie', 'price' => 45, 'category' => 'mobile'),
        array('id' => 12, 'name' => 'Réparation console', 'price' => 55, 'category' => 'mobile'),
        array('id' => 13, 'name' => 'Formation PC', 'price' => 65, 'category' => 'formation'),
        array('id' => 14, 'name' => 'Formation smartphone', 'price' => 45, 'category' => 'formation'),
        array('id' => 15, 'name' => 'Formation logiciels', 'price' => 55, 'category' => 'formation'),
    );
}

/**
 * Meta box personnalisée pour les détails du devis
 */
function webmatic_devis_meta_box() {
    add_meta_box(
        'devis_details',
        __('Détails du Devis', 'webmatic'),
        'webmatic_devis_meta_box_callback',
        'devis',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'webmatic_devis_meta_box');

function webmatic_devis_meta_box_callback($post) {
    $devis_data = array(
        'number' => get_post_meta($post->ID, 'devis_number', true),
        'prenom' => get_post_meta($post->ID, 'devis_prenom', true),
        'nom' => get_post_meta($post->ID, 'devis_nom', true),
        'email' => get_post_meta($post->ID, 'devis_email', true),
        'telephone' => get_post_meta($post->ID, 'devis_telephone', true),
        'adresse' => get_post_meta($post->ID, 'devis_adresse', true),
        'code_postal' => get_post_meta($post->ID, 'devis_code_postal', true),
        'ville' => get_post_meta($post->ID, 'devis_ville', true),
        'type_client' => get_post_meta($post->ID, 'devis_type_client', true),
        'nom_entreprise' => get_post_meta($post->ID, 'devis_nom_entreprise', true),
        'siret' => get_post_meta($post->ID, 'devis_siret', true),
        'services' => get_post_meta($post->ID, 'devis_services', true),
        'montant' => get_post_meta($post->ID, 'devis_montant', true),
        'statut' => get_post_meta($post->ID, 'devis_statut', true),
    );
    
    ?>
    <div class="devis-details">
        <h3><?php _e('Informations Client', 'webmatic'); ?></h3>
        <table class="form-table">
            <tr>
                <th><?php _e('Numéro de devis', 'webmatic'); ?>:</th>
                <td><strong><?php echo esc_html($devis_data['number']); ?></strong></td>
            </tr>
            <tr>
                <th><?php _e('Client', 'webmatic'); ?>:</th>
                <td><?php echo esc_html($devis_data['prenom'] . ' ' . $devis_data['nom']); ?></td>
            </tr>
            <tr>
                <th><?php _e('Email', 'webmatic'); ?>:</th>
                <td><a href="mailto:<?php echo esc_attr($devis_data['email']); ?>"><?php echo esc_html($devis_data['email']); ?></a></td>
            </tr>
            <tr>
                <th><?php _e('Téléphone', 'webmatic'); ?>:</th>
                <td><a href="tel:<?php echo esc_attr($devis_data['telephone']); ?>"><?php echo esc_html($devis_data['telephone']); ?></a></td>
            </tr>
            <tr>
                <th><?php _e('Adresse', 'webmatic'); ?>:</th>
                <td><?php echo esc_html($devis_data['adresse'] . ', ' . $devis_data['code_postal'] . ' ' . $devis_data['ville']); ?></td>
            </tr>
            <tr>
                <th><?php _e('Type', 'webmatic'); ?>:</th>
                <td><?php echo esc_html(ucfirst($devis_data['type_client'])); ?></td>
            </tr>
            <?php if ($devis_data['type_client'] === 'entreprise') : ?>
            <tr>
                <th><?php _e('Entreprise', 'webmatic'); ?>:</th>
                <td><?php echo esc_html($devis_data['nom_entreprise']); ?> (SIRET: <?php echo esc_html($devis_data['siret']); ?>)</td>
            </tr>
            <?php endif; ?>
        </table>
        
        <h3><?php _e('Services Demandés', 'webmatic'); ?></h3>
        <?php if (!empty($devis_data['services'])) : ?>
        <table class="widefat">
            <thead>
                <tr>
                    <th><?php _e('Service', 'webmatic'); ?></th>
                    <th><?php _e('Quantité', 'webmatic'); ?></th>
                    <th><?php _e('Prix unitaire', 'webmatic'); ?></th>
                    <th><?php _e('Total', 'webmatic'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($devis_data['services'] as $service) : ?>
                <tr>
                    <td><?php echo esc_html($service['name']); ?></td>
                    <td><?php echo esc_html($service['quantity']); ?></td>
                    <td><?php echo number_format($service['price'], 2, ',', ' '); ?> €</td>
                    <td><?php echo number_format($service['price'] * $service['quantity'], 2, ',', ' '); ?> €</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3"><?php _e('Total HT', 'webmatic'); ?></th>
                    <th><?php echo number_format($devis_data['montant'], 2, ',', ' '); ?> €</th>
                </tr>
            </tfoot>
        </table>
        <?php endif; ?>
        
        <h3><?php _e('Statut', 'webmatic'); ?></h3>
        <?php wp_nonce_field('webmatic_devis_statut', 'webmatic_devis_statut_nonce'); ?>
        <select name="devis_statut" id="devis_statut">
            <option value="en_attente" <?php selected($devis_data['statut'], 'en_attente'); ?>><?php _e('En attente', 'webmatic'); ?></option>
            <option value="accepte" <?php selected($devis_data['statut'], 'accepte'); ?>><?php _e('Accepté', 'webmatic'); ?></option>
            <option value="refuse" <?php selected($devis_data['statut'], 'refuse'); ?>><?php _e('Refusé', 'webmatic'); ?></option>
        </select>
    </div>
    
    <style>
        .devis-details h3 { margin-top: 20px; margin-bottom: 10px; }
        .devis-details table { margin-bottom: 20px; }
        #devis_statut { padding: 5px 10px; font-size: 14px; }
    </style>
    <?php
}

/**
 * Sauvegarder le statut du devis
 */
function webmatic_save_devis_status($post_id) {
    if (!isset($_POST['webmatic_devis_statut_nonce']) || !wp_verify_nonce($_POST['webmatic_devis_statut_nonce'], 'webmatic_devis_statut')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['devis_statut'])) {
        update_post_meta($post_id, 'devis_statut', sanitize_text_field($_POST['devis_statut']));
    }
}
add_action('save_post_devis', 'webmatic_save_devis_status');