<?php
/**
 * Shortcodes pour WebMatic
 *
 * @package WebMatic
 */

if (!defined('ABSPATH')) exit;

/**
 * Shortcode: Formulaire de contact
 */
function webmatic_contact_form_shortcode($atts) {
    ob_start();
    
    $atts = shortcode_atts(array(
        'title' => '',
    ), $atts, 'webmatic_contact_form');
    
    $nom = __('Votre nom', 'webmatic');
    $email = __('Votre email', 'webmatic');
    $telephone = __('Votre téléphone', 'webmatic');
    $sujet = __('Sujet', 'webmatic');
    $message = __('Votre message', 'webmatic');
    $envoyer = __('Envoyer le message', 'webmatic');
    $placeholder_nom = __('Jean Dupont', 'webmatic');
    $placeholder_email = __('jean@exemple.fr', 'webmatic');
    $placeholder_tel = __('06 12 34 56 78', 'webmatic');
    
    ?>
    <form id="contact-form" class="webmatic-contact-form" method="post">
        <?php wp_nonce_field('webmatic_contact_nonce', 'contact_nonce'); ?>
        
        <div class="form-row">
            <div class="form-group">
                <label for="contact-name"><?php echo esc_html($nom); ?> <span class="required">*</span></label>
                <input type="text" id="contact-name" name="contact_name" placeholder="<?php echo esc_attr($placeholder_nom); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="contact-email"><?php echo esc_html($email); ?> <span class="required">*</span></label>
                <input type="email" id="contact-email" name="contact_email" placeholder="<?php echo esc_attr($placeholder_email); ?>" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="contact-phone"><?php echo esc_html($telephone); ?></label>
                <input type="tel" id="contact-phone" name="contact_phone" placeholder="<?php echo esc_attr($placeholder_tel); ?>">
            </div>
            
            <div class="form-group">
                <label for="contact-subject"><?php echo esc_html($sujet); ?> <span class="required">*</span></label>
                <input type="text" id="contact-subject" name="contact_subject" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="contact-message"><?php echo esc_html($message); ?> <span class="required">*</span></label>
            <textarea id="contact-message" name="contact_message" rows="5" required></textarea>
        </div>
        
        <div class="form-group form-submit">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane" aria-hidden="true"></i>
                <?php echo esc_html($envoyer); ?>
            </button>
        </div>
        
        <div id="contact-response" class="contact-response" style="display:none;"></div>
    </form>
    
    <script>
    jQuery(document).ready(function($) {
        var i18n = {
            sending: '<?php echo esc_js(__('Envoi...', 'webmatic')); ?>',
            send: '<?php echo esc_js(__('Envoyer le message', 'webmatic')); ?>',
            errorNet: '<?php echo esc_js(__('Erreur lors de l\'envoi', 'webmatic')); ?>',
            ajaxUrl: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>'
        };

        $('#contact-form').on('submit', function(e) {
            e.preventDefault();

            var $form = $(this);
            var $response = $('#contact-response');
            var $button = $form.find('button[type="submit"]');

            $button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> ' + i18n.sending);

            $.ajax({
                url: i18n.ajaxUrl,
                type: 'POST',
                data: $form.serialize() + '&action=webmatic_contact_form',
                success: function(response) {
                    $response.removeClass('error success').show();
                    if (response.success) {
                        $response.addClass('success').html('<i class="fas fa-check-circle"></i> ' + response.data.message);
                        $form[0].reset();
                    } else {
                        $response.addClass('error').html('<i class="fas fa-exclamation-circle"></i> ' + response.data.message);
                    }
                    $button.prop('disabled', false).html('<i class="fas fa-paper-plane"></i> ' + i18n.send);
                },
                error: function() {
                    $response.removeClass('success').addClass('error').show()
                        .html('<i class="fas fa-exclamation-circle"></i> ' + i18n.errorNet);
                    $button.prop('disabled', false).html('<i class="fas fa-paper-plane"></i> ' + i18n.send);
                }
            });
        });
    });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('webmatic_contact_form', 'webmatic_contact_form_shortcode');

/**
 * Handler AJAX pour le formulaire de contact
 */
function webmatic_handle_contact_form() {
    check_ajax_referer('webmatic_contact_nonce', 'contact_nonce');
    
    $name = sanitize_text_field($_POST['contact_name'] ?? '');
    $email = sanitize_email($_POST['contact_email'] ?? '');
    $phone = sanitize_text_field($_POST['contact_phone'] ?? '');
    $subject = sanitize_text_field($_POST['contact_subject'] ?? '');
    $message = sanitize_textarea_field($_POST['contact_message'] ?? '');
    
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        wp_send_json_error(array('message' => __('Veuillez remplir tous les champs obligatoires.', 'webmatic')));
    }
    
    if (!is_email($email)) {
        wp_send_json_error(array('message' => __('Veuillez entrer une adresse email valide.', 'webmatic')));
    }
    
    $to = get_theme_mod('webmatic_contact_email', get_option('admin_email'));
    $headers = array('Content-Type: text/html; charset=UTF-8', 'From: ' . $name . ' <' . $email . '>');
    
    $email_subject = '[' . get_bloginfo('name') . '] ' . $subject;
    $email_body = sprintf(
        "<h2>Nouveau message de contact</h2>
        <p><strong>Nom:</strong> %s</p>
        <p><strong>Email:</strong> %s</p>
        <p><strong>Téléphone:</strong> %s</p>
        <p><strong>Sujet:</strong> %s</p>
        <p><strong>Message:</strong></p>
        <p>%s</p>",
        esc_html($name),
        esc_html($email),
        esc_html($phone),
        esc_html($subject),
        nl2br(esc_html($message))
    );
    
    $sent = wp_mail($to, $email_subject, $email_body, $headers);
    
    if ($sent) {
        wp_send_json_success(array('message' => __('Votre message a été envoyé avec succès !', 'webmatic')));
    } else {
        wp_send_json_error(array('message' => __('Une erreur est survenue lors de l\'envoi du message. Veuillez réessayer.', 'webmatic')));
    }
}
add_action('wp_ajax_webmatic_contact_form', 'webmatic_handle_contact_form');
add_action('wp_ajax_nopriv_webmatic_contact_form', 'webmatic_handle_contact_form');

/**
 * Shortcode: Services par défaut (affiché quand aucun service n'existe)
 */
function webmatic_default_services_shortcode() {
    ob_start();
    
    $services = array(
        array(
            'icon' => 'fas fa-laptop-code',
            'title' => __('Développement Web', 'webmatic'),
            'description' => __('Sites vitrines, e-commerce et applications web sur mesure.', 'webmatic'),
            'features' => array(__('WordPress & React', 'webmatic'), __('Responsive design', 'webmatic'), __('SEO optimisé', 'webmatic')),
        ),
        array(
            'icon' => 'fas fa-tools',
            'title' => __('Maintenance Informatique', 'webmatic'),
            'description' => __('Réparation, optimisation et maintenance de vos équipements.', 'webmatic'),
            'features' => array(__('PC & Mac', 'webmatic'), __('Smartphones & tablettes', 'webmatic'), __('Intervention à domicile', 'webmatic')),
        ),
        array(
            'icon' => 'fas fa-gamepad',
            'title' => __('Gaming & Consoles', 'webmatic'),
            'description' => __('Installation, configuration et réparation de matériel gaming.', 'webmatic'),
            'features' => array(__('PC Gaming', 'webmatic'), __('Consoles', 'webmatic'), __('Périphériques', 'webmatic')),
        ),
        array(
            'icon' => 'fas fa-mobile-alt',
            'title' => __('Smartphones & Tablettes', 'webmatic'),
            'description' => __('Réparation écran, batterie et dépannage logiciel.', 'webmatic'),
            'features' => array(__('iPhone & Android', 'webmatic'), __('Écrans & batteries', 'webmatic'), __('Sauvegarde données', 'webmatic')),
        ),
    );
    
    foreach ($services as $service) :
    ?>
        <div class="service-card">
            <div class="service-icon">
                <i class="<?php echo esc_attr($service['icon']); ?>" aria-hidden="true"></i>
            </div>
            <h3><?php echo esc_html($service['title']); ?></h3>
            <div class="service-description">
                <p><?php echo esc_html($service['description']); ?></p>
            </div>
            <?php if (!empty($service['features'])) : ?>
                <ul class="service-features">
                    <?php foreach ($service['features'] as $feature) : ?>
                        <li>
                            <i class="fas fa-check" aria-hidden="true"></i>
                            <?php echo esc_html($feature); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    <?php
    endforeach;
    
    return ob_get_clean();
}
add_shortcode('webmatic_default_services', 'webmatic_default_services_shortcode');