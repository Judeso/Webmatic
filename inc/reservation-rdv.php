<?php
/**
 * Réservation RDV - Custom Post Type et Widget
 * 
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

/**
 * Enregistrer le Custom Post Type "Rendez-vous"
 */
function webmatic_register_rdv_post_type() {
    register_post_type('rdv', [
        'labels' => [
            'name' => __('Rendez-vous', 'webmatic'),
            'singular_name' => __('Rendez-vous', 'webmatic'),
            'add_new' => __('Nouveau RDV', 'webmatic'),
            'add_new_item' => __('Ajouter un RDV', 'webmatic'),
            'edit_item' => __('Modifier le RDV', 'webmatic'),
            'new_item' => __('Nouveau RDV', 'webmatic'),
            'view_item' => __('Voir le RDV', 'webmatic'),
            'search_items' => __('Rechercher RDV', 'webmatic'),
            'not_found' => __('Aucun RDV trouvé', 'webmatic'),
            'menu_name' => __('RDV', 'webmatic'),
        ],
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 26,
        'menu_icon' => 'dashicons-calendar-alt',
        'supports' => ['title'],
        'capability_type' => 'post',
        'capabilities' => [
            'create_posts' => false, // Créés via le formulaire frontend uniquement
        ],
        'map_meta_cap' => true,
    ]);
}
add_action('init', 'webmatic_register_rdv_post_type');

/**
 * Meta box pour les détails du RDV
 */
function webmatic_rdv_meta_boxes() {
    add_meta_box(
        'rdv_details',
        __('Détails du rendez-vous', 'webmatic'),
        'webmatic_rdv_meta_box_callback',
        'rdv',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'webmatic_rdv_meta_boxes');

function webmatic_rdv_meta_box_callback($post) {
    wp_nonce_field('webmatic_rdv_meta', 'webmatic_rdv_nonce');
    
    $fields = [
        'rdv_nom' => __('Nom', 'webmatic'),
        'rdv_prenom' => __('Prénom', 'webmatic'),
        'rdv_email' => __('Email', 'webmatic'),
        'rdv_telephone' => __('Téléphone', 'webmatic'),
        'rdv_date' => __('Date souhaitée', 'webmatic'),
        'rdv_heure' => __('Heure souhaitée', 'webmatic'),
        'rdv_service' => __('Type de service', 'webmatic'),
        'rdv_message' => __('Message', 'webmatic'),
        'rdv_statut' => __('Statut', 'webmatic'),
    ];
    
    $statuts = [
        'en_attente' => __('En attente', 'webmatic'),
        'confirme' => __('Confirmé', 'webmatic'),
        'annule' => __('Annulé', 'webmatic'),
        'termine' => __('Terminé', 'webmatic'),
    ];
    ?>
    <table class="form-table">
        <?php foreach ($fields as $field => $label) : 
            $value = get_post_meta($post->ID, $field, true);
        ?>
        <tr>
            <th><label for="<?php echo $field; ?>"><?php echo $label; ?></label></th>
            <td>
                <?php if ($field === 'rdv_statut') : ?>
                    <select id="<?php echo $field; ?>" name="<?php echo $field; ?>">
                        <?php foreach ($statuts as $key => $statut_label) : ?>
                            <option value="<?php echo $key; ?>" <?php selected($value, $key); ?>>
                                <?php echo $statut_label; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php elseif ($field === 'rdv_message') : ?>
                    <textarea id="<?php echo $field; ?>" name="<?php echo $field; ?>" rows="4" class="large-text"><?php echo esc_textarea($value); ?></textarea>
                <?php else : ?>
                    <input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo esc_attr($value); ?>" class="regular-text">
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php
}

function webmatic_save_rdv_meta($post_id) {
    if (!isset($_POST['webmatic_rdv_nonce']) || !wp_verify_nonce($_POST['webmatic_rdv_nonce'], 'webmatic_rdv_meta')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    
    $fields = ['rdv_nom', 'rdv_prenom', 'rdv_email', 'rdv_telephone', 'rdv_date', 'rdv_heure', 'rdv_service', 'rdv_message', 'rdv_statut'];
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post_rdv', 'webmatic_save_rdv_meta');

/**
 * Colonnes personnalisées dans la liste des RDV
 */
function webmatic_rdv_columns($columns) {
    return [
        'cb' => $columns['cb'],
        'title' => __('Référence', 'webmatic'),
        'client' => __('Client', 'webmatic'),
        'date_rdv' => __('Date RDV', 'webmatic'),
        'service' => __('Service', 'webmatic'),
        'statut' => __('Statut', 'webmatic'),
        'date' => __('Date demande', 'webmatic'),
    ];
}
add_filter('manage_rdv_posts_columns', 'webmatic_rdv_columns');

function webmatic_rdv_column_content($column, $post_id) {
    switch ($column) {
        case 'client':
            $nom = get_post_meta($post_id, 'rdv_nom', true);
            $prenom = get_post_meta($post_id, 'rdv_prenom', true);
            $email = get_post_meta($post_id, 'rdv_email', true);
            echo esc_html($prenom . ' ' . $nom) . '<br>';
            echo '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
            break;
            
        case 'date_rdv':
            $date = get_post_meta($post_id, 'rdv_date', true);
            $heure = get_post_meta($post_id, 'rdv_heure', true);
            echo esc_html($date);
            if ($heure) echo '<br>' . esc_html($heure);
            break;
            
        case 'service':
            echo esc_html(get_post_meta($post_id, 'rdv_service', true));
            break;
            
        case 'statut':
            $statut = get_post_meta($post_id, 'rdv_statut', true) ?: 'en_attente';
            $statuts = [
                'en_attente' => '<span style="color:#f0ad4e;">⏳ ' . __('En attente', 'webmatic') . '</span>',
                'confirme' => '<span style="color:#5cb85c;">✓ ' . __('Confirmé', 'webmatic') . '</span>',
                'annule' => '<span style="color:#d9534f;">✕ ' . __('Annulé', 'webmatic') . '</span>',
                'termine' => '<span style="color:#5bc0de;">✓ ' . __('Terminé', 'webmatic') . '</span>',
            ];
            echo $statuts[$statut] ?? $statut;
            break;
    }
}
add_action('manage_rdv_posts_custom_column', 'webmatic_rdv_column_content', 10, 2);

/**
 * Handler AJAX pour la réservation
 */
function webmatic_handle_rdv_form() {
    check_ajax_referer('webmatic_rdv_nonce', 'rdv_nonce');
    
    $nom = sanitize_text_field($_POST['rdv_nom'] ?? '');
    $prenom = sanitize_text_field($_POST['rdv_prenom'] ?? '');
    $email = sanitize_email($_POST['rdv_email'] ?? '');
    $telephone = sanitize_text_field($_POST['rdv_telephone'] ?? '');
    $date = sanitize_text_field($_POST['rdv_date'] ?? '');
    $heure = sanitize_text_field($_POST['rdv_heure'] ?? '');
    $service = sanitize_text_field($_POST['rdv_service'] ?? '');
    $message = sanitize_textarea_field($_POST['rdv_message'] ?? '');
    
    // Validation
    if (empty($nom) || empty($prenom) || empty($email) || empty($date) || empty($service)) {
        wp_send_json_error(['message' => __('Veuillez remplir tous les champs obligatoires.', 'webmatic')]);
    }
    
    if (!is_email($email)) {
        wp_send_json_error(['message' => __('Adresse email invalide.', 'webmatic')]);
    }
    
    // Créer le RDV
    $rdv_id = wp_insert_post([
        'post_type' => 'rdv',
        'post_title' => 'RDV-' . date('Ymd') . '-' . $nom,
        'post_status' => 'publish',
        'post_author' => 1,
    ]);
    
    if (is_wp_error($rdv_id)) {
        wp_send_json_error(['message' => __('Erreur lors de la création du rendez-vous.', 'webmatic')]);
    }
    
    // Sauvegarder les métadonnées
    update_post_meta($rdv_id, 'rdv_nom', $nom);
    update_post_meta($rdv_id, 'rdv_prenom', $prenom);
    update_post_meta($rdv_id, 'rdv_email', $email);
    update_post_meta($rdv_id, 'rdv_telephone', $telephone);
    update_post_meta($rdv_id, 'rdv_date', $date);
    update_post_meta($rdv_id, 'rdv_heure', $heure);
    update_post_meta($rdv_id, 'rdv_service', $service);
    update_post_meta($rdv_id, 'rdv_message', $message);
    update_post_meta($rdv_id, 'rdv_statut', 'en_attente');
    
    // Envoyer email notification
    $to = get_option('admin_email');
    $subject = '[' . get_bloginfo('name') . '] Nouveau rendez-vous demandé';
    $body = sprintf(
        "Nouvelle demande de rendez-vous\n\n" .
        "Client: %s %s\n" .
        "Email: %s\n" .
        "Téléphone: %s\n" .
        "Service: %s\n" .
        "Date souhaitée: %s à %s\n" .
        "Message: %s\n\n" .
        "Gérer ce RDV: %s",
        $prenom,
        $nom,
        $email,
        $telephone,
        $service,
        $date,
        $heure,
        $message,
        admin_url('post.php?post=' . $rdv_id . '&action=edit')
    );
    
    wp_mail($to, $subject, $body);
    
    // Email confirmation client
    $client_subject = '[' . get_bloginfo('name') . '] Confirmation de votre demande de rendez-vous';
    $client_body = sprintf(
        "Bonjour %s,\n\n" .
        "Nous avons bien reçu votre demande de rendez-vous.\n\n" .
        "Détails de votre demande:\n" .
        "Service: %s\n" .
        "Date souhaitée: %s à %s\n\n" .
        "Nous vous contacterons très vite pour confirmer ce rendez-vous.\n\n" .
        "Cordialement,\n" .
        "L'équipe %s",
        $prenom,
        $service,
        $date,
        $heure,
        get_bloginfo('name')
    );
    
    wp_mail($email, $client_subject, $client_body);
    
    wp_send_json_success(['message' => __('Votre demande de rendez-vous a été envoyée ! Nous vous contacterons pour confirmer.', 'webmatic')]);
}
add_action('wp_ajax_webmatic_rdv_form', 'webmatic_handle_rdv_form');
add_action('wp_ajax_nopriv_webmatic_rdv_form', 'webmatic_handle_rdv_form');

/**
 * Shortcode formulaire de réservation
 */
function webmatic_rdv_form_shortcode($atts) {
    ob_start();
    
    $services = [
        'site-vitrine' => __('Site Vitrine', 'webmatic'),
        'e-commerce' => __('E-Commerce', 'webmatic'),
        'maintenance' => __('Maintenance Informatique', 'webmatic'),
        'depannage' => __('Dépannage PC/MAC', 'webmatic'),
        'smartphone' => __('Réparation Smartphone', 'webmatic'),
        'autre' => __('Autre demande', 'webmatic'),
    ];
    ?>
    <form id="rdv-form" class="rdv-form webmatic-form" method="post">
        <?php wp_nonce_field('webmatic_rdv_nonce', 'rdv_nonce'); ?>
        
        <div class="form-row">
            <div class="form-group">
                <label for="rdv-prenom"><?php _e('Prénom *', 'webmatic'); ?></label>
                <input type="text" id="rdv-prenom" name="rdv_prenom" required>
            </div>
            <div class="form-group">
                <label for="rdv-nom"><?php _e('Nom *', 'webmatic'); ?></label>
                <input type="text" id="rdv-nom" name="rdv_nom" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="rdv-email"><?php _e('Email *', 'webmatic'); ?></label>
                <input type="email" id="rdv-email" name="rdv_email" required>
            </div>
            <div class="form-group">
                <label for="rdv-telephone"><?php _e('Téléphone', 'webmatic'); ?></label>
                <input type="tel" id="rdv-telephone" name="rdv_telephone">
            </div>
        </div>
        
        <div class="form-group">
            <label for="rdv-service"><?php _e('Type de service *', 'webmatic'); ?></label>
            <select id="rdv-service" name="rdv_service" required>
                <option value=""><?php _e('Sélectionnez un service', 'webmatic'); ?></option>
                <?php foreach ($services as $key => $label) : ?>
                    <option value="<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="rdv-date"><?php _e('Date souhaitée *', 'webmatic'); ?></label>
                <input type="date" id="rdv-date" name="rdv_date" required min="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="form-group">
                <label for="rdv-heure"><?php _e('Heure préférée', 'webmatic'); ?></label>
                <select id="rdv-heure" name="rdv_heure">
                    <option value=""><?php _e('Indifférent', 'webmatic'); ?></option>
                    <option value="09:00">09:00</option>
                    <option value="10:00">10:00</option>
                    <option value="11:00">11:00</option>
                    <option value="14:00">14:00</option>
                    <option value="15:00">15:00</option>
                    <option value="16:00">16:00</option>
                    <option value="17:00">17:00</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label for="rdv-message"><?php _e('Message / Détails', 'webmatic'); ?></label>
            <textarea id="rdv-message" name="rdv_message" rows="4"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-calendar-check"></i>
            <?php _e('Demander un rendez-vous', 'webmatic'); ?>
        </button>
        
        <div id="rdv-response" class="form-response" style="display:none;"></div>
    </form>
    
    <script>
    jQuery(document).ready(function($) {
        $('#rdv-form').on('submit', function(e) {
            e.preventDefault();
            
            var $form = $(this);
            var $response = $('#rdv-response');
            var $button = $form.find('button[type="submit"]');
            
            $button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> <?php echo esc_js(__('Envoi...', 'webmatic')); ?>');
            
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: $form.serialize() + '&action=webmatic_rdv_form',
                success: function(response) {
                    $response.show();
                    if (response.success) {
                        $response.addClass('success').removeClass('error').html('<i class="fas fa-check-circle"></i> ' + response.data.message);
                        $form[0].reset();
                    } else {
                        $response.addClass('error').removeClass('success').html('<i class="fas fa-exclamation-circle"></i> ' + response.data.message);
                    }
                    $button.prop('disabled', false).html('<i class="fas fa-calendar-check"></i> <?php echo esc_js(__('Demander un rendez-vous', 'webmatic')); ?>');
                },
                error: function() {
                    $response.show().addClass('error').html('<i class="fas fa-exclamation-circle"></i> <?php echo esc_js(__('Erreur lors de l\'envoi.', 'webmatic')); ?>');
                    $button.prop('disabled', false).html('<i class="fas fa-calendar-check"></i> <?php echo esc_js(__('Demander un rendez-vous', 'webmatic')); ?>');
                }
            });
        });
    });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('webmatic_rdv_form', 'webmatic_rdv_form_shortcode');
