<?php
/**
 * Template Name: RGPD - Droits des personnes
 * Description: Page d'information sur les droits RGPD
 *
 * @package WebMatic
 */

get_header();
?>

<main id="main" class="site-main legal-page" role="main">
    <div class="container">
        <div class="legal-content">
            <h1><?php _e('RGPD - Vos Droits sur vos Données', 'webmatic'); ?></h1>
            
            <p class="legal-intro">
                <?php _e('Le Règlement Général sur la Protection des Données (RGPD) renforce vos droits sur vos données personnelles. Découvrez comment les exercer chez WebMatic.', 'webmatic'); ?>
            </p>

            <section class="legal-section">
                <h2><?php _e('Qu\'est-ce que le RGPD ?', 'webmatic'); ?></h2>
                <p>
                    <?php _e('Le RGPD (Règlement (UE) 2016/679) est un règlement européen qui uniformise et renforce la protection des données personnelles au sein de l\'Union Européenne. Il s\'applique depuis le 25 mai 2018.', 'webmatic'); ?>
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('Vos droits en détail', 'webmatic'); ?></h2>
                
                <div class="rgpd-right">
                    <h3><i class="fas fa-eye"></i> <?php _e('1. Droit d\'accès', 'webmatic'); ?></h3>
                    <p>
                        <?php _e('Vous pouvez demander à consulter toutes les données personnelles que nous détenons sur vous. Cela inclut :', 'webmatic'); ?>
                    </p>
                    <ul>
                        <li><?php _e('Les données que vous nous avez fournies', 'webmatic'); ?></li>
                        <li><?php _e('L\'origine de ces données', 'webmatic'); ?></li>
                        <li><?php _e('Les finalités du traitement', 'webmatic'); ?></li>
                        <li><?php _e('Les destinataires de ces données', 'webmatic'); ?></li>
                    </ul>
                    <p><strong><?php _e('Délai de réponse :', 'webmatic'); ?></strong> <?php _e('1 mois maximum', 'webmatic'); ?></p>
                </div>

                <div class="rgpd-right">
                    <h3><i class="fas fa-edit"></i> <?php _e('2. Droit de rectification', 'webmatic'); ?></h3>
                    <p>
                        <?php _e('Si vos données sont inexactes ou incomplètes, vous pouvez demander leur correction à tout moment.', 'webmatic'); ?>
                    </p>
                </div>

                <div class="rgpd-right">
                    <h3><i class="fas fa-trash-alt"></i> <?php _e('3. Droit à l\'effacement (droit à l\'oubli)', 'webmatic'); ?></h3>
                    <p>
                        <?php _e('Vous pouvez demander la suppression de vos données dans les cas suivants :', 'webmatic'); ?>
                    </p>
                    <ul>
                        <li><?php _e('Les données ne sont plus nécessaires pour les finalités initiales', 'webmatic'); ?></li>
                        <li><?php _e('Vous retirez votre consentement', 'webmatic'); ?></li>
                        <li><?php _e('Vous vous opposez au traitement', 'webmatic'); ?></li>
                        <li><?php _e('Les données ont été traitées illégalement', 'webmatic'); ?></li>
                    </ul>
                    <p class="rgpd-note">
                        <i class="fas fa-info-circle"></i>
                        <?php _e('Note : Ce droit ne s\'applique pas si nous avons une obligation légale de conservation.', 'webmatic'); ?>
                    </p>
                </div>

                <div class="rgpd-right">
                    <h3><i class="fas fa-pause-circle"></i> <?php _e('4. Droit à la limitation du traitement', 'webmatic'); ?></h3>
                    <p>
                        <?php _e('Vous pouvez demander le gel temporaire de l\'utilisation de vos données dans certaines situations.', 'webmatic'); ?>
                    </p>
                </div>

                <div class="rgpd-right">
                    <h3><i class="fas fa-file-export"></i> <?php _e('5. Droit à la portabilité', 'webmatic'); ?></h3>
                    <p>
                        <?php _e('Vous pouvez recevoir vos données dans un format structuré et lisible par machine (JSON, CSV), ou demander leur transfert direct à un autre responsable du traitement.', 'webmatic'); ?>
                    </p>
                </div>

                <div class="rgpd-right">
                    <h3><i class="fas fa-ban"></i> <?php _e('6. Droit d\'opposition', 'webmatic'); ?></h3>
                    <p>
                        <?php _e('Vous pouvez vous opposer à tout moment au traitement de vos données, notamment pour la prospection commerciale.', 'webmatic'); ?>
                    </p>
                </div>
            </section>

            <section class="legal-section">
                <h2><?php _e('Comment exercer vos droits ?', 'webmatic'); ?></h2>
                <p>
                    <?php _e('Pour exercer l\'un de ces droits, vous pouvez nous contacter par :', 'webmatic'); ?>
                </p>
                <div class="contact-methods">
                    <div class="contact-method">
                        <i class="fas fa-envelope"></i>
                        <h4><?php _e('Email', 'webmatic'); ?></h4>
                        <?php if ($email = get_theme_mod('webmatic_email')) : ?>
                            <a href="mailto:<?php echo esc_attr($email); ?>?subject=Demande%20RGPD"><?php echo esc_html($email); ?></a>
                        <?php endif; ?>
                    </div>
                    
                    <div class="contact-method">
                        <i class="fas fa-phone"></i>
                        <h4><?php _e('Téléphone', 'webmatic'); ?></h4>
                        <?php if ($phone = get_theme_mod('webmatic_phone')) : ?>
                            <p><?php echo esc_html($phone); ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="contact-method">
                        <i class="fas fa-mail-bulk"></i>
                        <h4><?php _e('Courrier', 'webmatic'); ?></h4>
                        <?php if ($address = get_theme_mod('webmatic_address')) : ?>
                            <p><?php echo esc_html($address); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <p class="rgpd-note">
                    <strong><?php _e('Pièce d\'identité requise :', 'webmatic'); ?></strong>
                    <?php _e('Pour votre sécurité, nous pourrons vous demander une copie de votre pièce d\'identité afin de vérifier votre identité avant de donner suite à votre demande.', 'webmatic'); ?>
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('Réclamation auprès de la CNIL', 'webmatic'); ?></h2>
                <p>
                    <?php _e('Si vous estimez que le traitement de vos données ne respecte pas le RGPD, vous avez le droit d\'introduire une réclamation auprès de la Commission Nationale de l\'Informatique et des Libertés (CNIL).', 'webmatic'); ?>
                </p>
                <div class="cnil-info">
                    <p><strong>CNIL</strong><br>
                    3 Place de Fontenoy<br>
                    TSA 80715 - 75334 Paris Cedex 07<br>
                    <a href="https://www.cnil.fr" target="_blank" rel="noopener">www.cnil.fr</a> | 
                    <a href="tel:01%2053%2073%2022%2022">01 53 73 22 22</a></p>
                </div>
            </section>

            <section class="legal-section">
                <h2><?php _e('Notre engagement RGPD', 'webmatic'); ?></h2>
                <p>
                    <?php _e('WebMatic s\'engage à :', 'webmatic'); ?>
                </p>
                <ul>
                    <li><?php _e('Ne collecter que les données nécessaires (minimisation des données)', 'webmatic'); ?></li>
                    <li><?php _e('Vous informer clairement de l\'utilisation de vos données', 'webmatic'); ?></li>
                    <li><?php _e('Respecter les délais légaux pour répondre à vos demandes', 'webmatic'); ?></li>
                    <li><?php _e('Maintenir la sécurité et la confidentialité de vos données', 'webmatic'); ?></li>
                    <li><?php _e('Ne pas céder vos données à des tiers sans votre consentement', 'webmatic'); ?></li>
                </ul>
            </section>

            <p class="legal-date">
                <?php _e('Dernière mise à jour :', 'webmatic'); ?> <?php echo date('F Y'); ?>
            </p>
        </div>
    </div>
</main>

<?php
get_footer();
