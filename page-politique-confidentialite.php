<?php
/**
 * Template Name: Politique de Confidentialité
 * Description: Page politique de confidentialité RGPD
 *
 * @package WebMatic
 */

get_header();
?>

<main id="main" class="site-main legal-page" role="main">
    <div class="container">
        <div class="legal-content">
            <h1><?php _e('Politique de Confidentialité', 'webmatic'); ?></h1>
            
            <p class="legal-intro">
                <?php _e('WebMatic s\'engage à protéger la vie privée des utilisateurs de son site. La présente politique de confidentialité décrit la manière dont nous collectons, utilisons et protégeons vos données personnelles.', 'webmatic'); ?>
            </p>

            <section class="legal-section">
                <h2><?php _e('1. Responsable du traitement', 'webmatic'); ?></h2>
                <p>
                    <strong>WebMatic</strong><br>
                    <?php if ($email = get_theme_mod('webmatic_email')) : ?>
                        Email : <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a><br>
                    <?php endif; ?>
                    <?php if ($phone = get_theme_mod('webmatic_phone')) : ?>
                        Téléphone : <?php echo esc_html($phone); ?>
                    <?php endif; ?>
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('2. Données collectées', 'webmatic'); ?></h2>
                <p><?php _e('Nous collectons les données suivantes :', 'webmatic'); ?></p>
                <ul>
                    <li><?php _e('<strong>Données de contact :</strong> nom, prénom, email, téléphone (lors de l\'utilisation du formulaire de contact)', 'webmatic'); ?></li>
                    <li><?php _e('<strong>Données de navigation :</strong> adresse IP, type de navigateur, pages visitées, durée de visite', 'webmatic'); ?></li>
                    <li><?php _e('<strong>Cookies :</strong> informations relatives à votre navigation sur notre site', 'webmatic'); ?></li>
                </ul>
            </section>

            <section class="legal-section">
                <h2><?php _e('3. Finalités du traitement', 'webmatic'); ?></h2>
                <p><?php _e('Vos données sont collectées pour les finalités suivantes :', 'webmatic'); ?></p>
                <ul>
                    <li><?php _e('Répondre à vos demandes et messages via le formulaire de contact', 'webmatic'); ?></li>
                    <li><?php _e('Améliorer l\'expérience utilisateur et la navigation sur le site', 'webmatic'); ?></li>
                    <li><?php _e('Réaliser des statistiques anonymisées de fréquentation', 'webmatic'); ?></li>
                    <li><?php _e('Respecter nos obligations légales et réglementaires', 'webmatic'); ?></li>
                </ul>
            </section>

            <section class="legal-section">
                <h2><?php _e('4. Base légale du traitement', 'webmatic'); ?></h2>
                <p><?php _e('Le traitement de vos données repose sur les bases légales suivantes :', 'webmatic'); ?></p>
                <ul>
                    <li><?php _e('<strong>Consentement :</strong> lorsque vous acceptez l\'utilisation des cookies', 'webmatic'); ?></li>
                    <li><?php _e('<strong>Exécution d\'un contrat :</strong> pour répondre à vos demandes de devis', 'webmatic'); ?></li>
                    <li><?php _e('<strong>Intérêt légitime :</strong> pour la sécurité du site et l\'amélioration de nos services', 'webmatic'); ?></li>
                    <li><?php _e('<strong>Obligation légale :</strong> pour respecter nos obligations comptables et fiscales', 'webmatic'); ?></li>
                </ul>
            </section>

            <section class="legal-section">
                <h2><?php _e('5. Durée de conservation', 'webmatic'); ?></h2>
                <table class="legal-table">
                    <thead>
                        <tr>
                            <th><?php _e('Type de données', 'webmatic'); ?></th>
                            <th><?php _e('Durée de conservation', 'webmatic'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php _e('Données de contact (formulaire)', 'webmatic'); ?></td>
                            <td><?php _e('3 ans après le dernier contact', 'webmatic'); ?></td>
                        </tr>
                        <tr>
                            <td><?php _e('Cookies de navigation', 'webmatic'); ?></td>
                            <td><?php _e('13 mois maximum', 'webmatic'); ?></td>
                        </tr>
                        <tr>
                            <td><?php _e('Données de connexion', 'webmatic'); ?></td>
                            <td><?php _e('1 an (obligation légale)', 'webmatic'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section class="legal-section">
                <h2><?php _e('6. Vos droits', 'webmatic'); ?></h2>
                <p><?php _e('Conformément au Règlement Général sur la Protection des Données (RGPD), vous disposez des droits suivants :', 'webmatic'); ?></p>
                <ul>
                    <li><strong><?php _e('Droit d\'accès :', 'webmatic'); ?></strong> <?php _e('obtenir une copie de vos données personnelles', 'webmatic'); ?></li>
                    <li><strong><?php _e('Droit de rectification :', 'webmatic'); ?></strong> <?php _e('faire corriger des données inexactes', 'webmatic'); ?></li>
                    <li><strong><?php _e('Droit à l\'effacement :', 'webmatic'); ?></strong> <?php _e('demander la suppression de vos données', 'webmatic'); ?></li>
                    <li><strong><?php _e('Droit à la limitation :', 'webmatic'); ?></strong> <?php _e('demander la limitation du traitement', 'webmatic'); ?></li>
                    <li><strong><?php _e('Droit à la portabilité :', 'webmatic'); ?></strong> <?php _e('recevoir vos données dans un format structuré', 'webmatic'); ?></li>
                    <li><strong><?php _e('Droit d\'opposition :', 'webmatic'); ?></strong> <?php _e('vous opposer au traitement de vos données', 'webmatic'); ?></li>
                </ul>
                <p>
                    <?php _e('Pour exercer ces droits, contactez-nous à :', 'webmatic'); ?>
                    <?php if ($email = get_theme_mod('webmatic_email')) : ?>
                        <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                    <?php endif; ?>
                </p>
                <p>
                    <?php _e('Vous avez également le droit d\'introduire une réclamation auprès de la CNIL :', 'webmatic'); ?>
                    <a href="https://www.cnil.fr" target="_blank" rel="noopener">www.cnil.fr</a>
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('7. Cookies', 'webmatic'); ?></h2>
                <p><?php _e('Notre site utilise différents types de cookies :', 'webmatic'); ?></p>
                <ul>
                    <li><strong><?php _e('Cookies essentiels :', 'webmatic'); ?></strong> <?php _e('nécessaires au fonctionnement du site (ne nécessitent pas de consentement)', 'webmatic'); ?></li>
                    <li><strong><?php _e('Cookies de performance :', 'webmatic'); ?></strong> <?php _e('aident à améliorer le site (Google Analytics, etc.)', 'webmatic'); ?></li>
                    <li><strong><?php _e('Cookies de préférences :', 'webmatic'); ?></strong> <?php _e('mémorisent vos choix (langue, etc.)', 'webmatic'); ?></li>
                </ul>
                <p>
                    <?php _e('Vous pouvez gérer vos préférences de cookies à tout moment via le bandeau de cookies présent sur le site.', 'webmatic'); ?>
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('8. Sécurité', 'webmatic'); ?></h2>
                <p>
                    <?php _e('Nous mettons en œuvre des mesures techniques et organisationnelles appropriées pour protéger vos données contre la perte, l\'accès non autorisé, la modification ou la divulgation.', 'webmatic'); ?>
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('9. Modifications', 'webmatic'); ?></h2>
                <p>
                    <?php _e('Nous nous réservons le droit de modifier cette politique de confidentialité à tout moment. Les modifications prendront effet dès leur publication sur le site.', 'webmatic'); ?>
                </p>
            </section>

            <p class="legal-date">
                <?php _e('Dernière mise à jour :', 'webmatic'); ?> <?php echo date('F Y'); ?>
            </p>
        </div>
    </div>
</main>

<?php
get_footer();
