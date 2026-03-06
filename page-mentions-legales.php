<?php
/**
 * Template Name: Mentions Légales
 * Description: Page mentions légales conforme au droit français
 *
 * @package WebMatic
 */

get_header();
?>

<main id="main" class="site-main legal-page" role="main">
    <div class="container">
        <div class="legal-content">
            <h1><?php _e('Mentions Légales', 'webmatic'); ?></h1>
            
            <section class="legal-section">
                <h2><?php _e('1. Éditeur du site', 'webmatic'); ?></h2>
                <p>
                    <strong><?php bloginfo('name'); ?></strong><br>
                    <?php _e('Entreprise individuelle / Auto-entrepreneur', 'webmatic'); ?><br>
                    <?php if ($address = get_theme_mod('webmatic_address')) : ?>
                        <?php echo esc_html($address); ?><br>
                    <?php endif; ?>
                    <?php if ($email = get_theme_mod('webmatic_email')) : ?>
                        Email : <?php echo esc_html($email); ?><br>
                    <?php endif; ?>
                    <?php if ($phone = get_theme_mod('webmatic_phone')) : ?>
                        Téléphone : <?php echo esc_html($phone); ?>
                    <?php endif; ?>
                </p>
                <p>
                    <strong><?php _e('Numéro SIRET :', 'webmatic'); ?></strong> [À compléter]<br>
                    <strong><?php _e('Code APE :', 'webmatic'); ?></strong> 62.01Z - Programmation informatique
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('2. Directeur de la publication', 'webmatic'); ?></h2>
                <p>[Nom du responsable]</p>
            </section>

            <section class="legal-section">
                <h2><?php _e('3. Hébergeur', 'webmatic'); ?></h2>
                <p>
                    <strong>LWS (Ligne Web Services)</strong><br>
                    SARL au capital de 1 000 000 €<br>
                    RCS Paris B 450 078 458<br>
                    Siège social : 10 Rue de Penthièvre, 75008 Paris<br>
                    Téléphone : 01 77 62 30 03
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('4. Propriété intellectuelle', 'webmatic'); ?></h2>
                <p>
                    <?php _e('L\'ensemble du contenu du présent site Internet, incluant, de façon non limitative, les graphismes, images, textes, vidéos, animations, sons, logos, gifs et icônes ainsi que leur mise en forme sont la propriété exclusive de la société à l\'exception des marques, logos ou contenus appartenant à d\'autres sociétés partenaires ou auteurs.', 'webmatic'); ?>
                </p>
                <p>
                    <?php _e('Toute reproduction, distribution, modification, adaptation, retransmission ou publication, même partielle, de ces différents éléments est strictement interdite sans l\'accord écrit exprès de WebMatic. Cette représentation ou reproduction, par quelque procédé que ce soit, constitue une contrefaçon sanctionnée par les articles L.335-2 et suivants du Code de la propriété intellectuelle.', 'webmatic'); ?>
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('5. Données personnelles', 'webmatic'); ?></h2>
                <p>
                    <?php _e('Conformément à la loi Informatique et Libertés du 6 janvier 1978 modifiée, vous disposez d\'un droit d\'accès, de rectification et de suppression des données vous concernant. Pour l\'exercer, veuillez nous contacter via le formulaire de contact ou à l\'adresse email :', 'webmatic'); ?>
                    <?php if ($email = get_theme_mod('webmatic_email')) : ?>
                        <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                    <?php endif; ?>
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('6. Cookies', 'webmatic'); ?></h2>
                <p>
                    <?php _e('Le site WebMatic peut être amené à vous demander l\'acceptation des cookies pour des besoins de statistiques et d\'affichage. Un cookie est une information déposée sur votre disque dur par le serveur du site que vous visitez. Il contient plusieurs données qui sont stockées sur votre ordinateur dans un simple fichier texte auquel un serveur accède pour lire et enregistrer des informations.', 'webmatic'); ?>
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('7. Limitation de responsabilité', 'webmatic'); ?></h2>
                <p>
                    <?php _e('Les informations contenues sur ce site sont aussi précises que possibles et le site est périodiquement remis à jour, mais peut toutefois contenir des inexactitudes, des omissions ou des lacunes. Si vous constatez une lacune, erreur ou ce qui parait être un dysfonctionnement, merci de bien vouloir le signaler par email en décrivant le problème de la manière la plus précise possible.', 'webmatic'); ?>
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('8. Droit applicable', 'webmatic'); ?></h2>
                <p>
                    <?php _e('Les présentes conditions sont régies par les lois françaises. Tout litige relatif à l\'interprétation ou à l\'exécution des présentes conditions sera de la compétence exclusive des tribunaux français.', 'webmatic'); ?>
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
