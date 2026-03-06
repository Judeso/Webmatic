<?php
/**
 * Template de la page d'accueil
 *
 * @package WebMatic
 */

get_header();

// Vérifier si Elementor est utilisé pour cette page
$is_elementor_edited = function_exists('webmatic_is_elementor_edited') && webmatic_is_elementor_edited();
?>

<main id="main" class="site-main home-page" role="main">

    <?php
    // Zone Elementor - OBLIGATOIRE pour que l'éditeur fonctionne
    if (have_posts()) :
        while (have_posts()) :
            the_post();

            // Si Elementor est utilisé, afficher uniquement le contenu Elementor
            if ($is_elementor_edited) :
                the_content();
            else :
                // Sinon, afficher le contenu par défaut du thème
                ?>

    <!-- Section Hero -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">
                    <?php echo esc_html(get_theme_mod('webmatic_hero_title', "L'informatique côté pratique")); ?>
                </h1>
                <p class="hero-subtitle">
                    <?php echo esc_html(get_theme_mod('webmatic_hero_subtitle', 'Développeur web expérimenté et technicien informatique passionné. Solutions créatives pour votre présence en ligne et maintenance complète de vos équipements.')); ?>
                </p>
                <div class="hero-buttons">
                    <a href="#services" class="btn btn-primary">
                        <i class="fas fa-bolt" aria-hidden="true"></i>
                        <?php esc_html_e('Découvrir mes services', 'webmatic'); ?>
                    </a>
                    <a href="tel:<?php echo esc_attr(str_replace(' ', '', get_theme_mod('webmatic_phone', '0756913061'))); ?>" class="btn btn-secondary">
                        <i class="fas fa-phone" aria-hidden="true"></i>
                        <?php echo esc_html(get_theme_mod('webmatic_phone', '07 56 91 30 61')); ?>
                    </a>
                </div>
                <div class="hero-features">
                    <span><i class="fas fa-check-circle" aria-hidden="true"></i> <?php esc_html_e('Devis gratuit', 'webmatic'); ?></span>
                    <span><i class="fas fa-clock" aria-hidden="true"></i> <?php esc_html_e('Intervention rapide', 'webmatic'); ?></span>
                </div>
            </div>

            <?php
            $hero_image = get_theme_mod('webmatic_hero_image');
            if ($hero_image) : ?>
                <div class="hero-image">
                    <img src="<?php echo esc_url($hero_image); ?>"
                         alt="<?php esc_attr_e('Innovation technologique', 'webmatic'); ?>"
                         loading="eager">
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Section Services -->
    <section id="services" class="services-section">
        <div class="container">
            <div class="section-header">
                <h2><?php esc_html_e('Mes Services', 'webmatic'); ?></h2>
                <p><?php esc_html_e('Solutions complètes pour tous vos besoins informatiques et web', 'webmatic'); ?></p>
            </div>

            <div class="services-grid">
                <?php
                $services = new WP_Query(array(
                    'post_type'      => 'service',
                    'posts_per_page' => -1,
                    'orderby'        => 'menu_order',
                    'order'          => 'ASC',
                    'no_found_rows'  => true,
                ));

                if ($services->have_posts()) :
                    while ($services->have_posts()) :
                        $services->the_post();
                        $icon     = get_post_meta(get_the_ID(), 'service_icon', true) ?: 'fas fa-cog';
                        $features = get_post_meta(get_the_ID(), 'service_features', true);
                        ?>
                        <div class="service-card" data-testid="service-card-<?php echo esc_attr(get_the_ID()); ?>">
                            <div class="service-icon">
                                <i class="<?php echo esc_attr($icon); ?>" aria-hidden="true"></i>
                            </div>
                            <h3><?php the_title(); ?></h3>
                            <div class="service-description">
                                <?php the_excerpt(); ?>
                            </div>
                            <?php if ($features && is_array($features)) : ?>
                                <ul class="service-features">
                                    <?php foreach ($features as $feature) : ?>
                                        <li>
                                            <i class="fas fa-check" aria-hidden="true"></i>
                                            <?php echo esc_html($feature); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            <a href="<?php the_permalink(); ?>" class="btn-link">
                                <?php esc_html_e('En savoir plus', 'webmatic'); ?>
                                <i class="fas fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo do_shortcode('[webmatic_default_services]');
                endif;
                ?>
            </div>
        </div>
    </section>

    <!-- Section Générateur de Devis -->
    <?php if (get_theme_mod('webmatic_show_devis_section', true)) :
        $devis_page = get_theme_mod('webmatic_devis_page');
    ?>
        <section class="devis-promo-section">
            <div class="container">
                <div class="devis-promo-content">
                    <h2><?php esc_html_e('Générateur de Devis', 'webmatic'); ?></h2>
                    <p><?php esc_html_e('Créez votre devis personnalisé en quelques clics et recevez-le instantanément', 'webmatic'); ?></p>
                    <?php if ($devis_page) : ?>
                        <a href="<?php echo esc_url(get_permalink($devis_page)); ?>"
                           class="btn btn-large btn-primary"
                           data-testid="create-devis-btn">
                            <i class="fas fa-file-invoice" aria-hidden="true"></i>
                            <?php esc_html_e('Créer mon devis', 'webmatic'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Section Réalisations -->
    <section class="realisations-section">
        <div class="container">
            <div class="section-header">
                <h2><?php esc_html_e('Mes Réalisations', 'webmatic'); ?></h2>
                <p><?php esc_html_e("Découvrez quelques projets que j'ai eu le plaisir de réaliser", 'webmatic'); ?></p>
            </div>

            <div class="realisations-grid">
                <?php
                $realisations = new WP_Query(array(
                    'post_type'      => 'realisation',
                    'posts_per_page' => 6,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                    'no_found_rows'  => true,
                ));

                if ($realisations->have_posts()) :
                    while ($realisations->have_posts()) :
                        $realisations->the_post();
                        $url  = get_post_meta(get_the_ID(), 'realisation_url', true);
                        $tags = get_post_meta(get_the_ID(), 'realisation_tags', true);
                        ?>
                        <div class="realisation-card" data-testid="realisation-card-<?php echo esc_attr(get_the_ID()); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="realisation-image">
                                    <?php the_post_thumbnail('webmatic-realisation', array('loading' => 'lazy')); ?>
                                </div>
                            <?php endif; ?>
                            <div class="realisation-content">
                                <h3><?php the_title(); ?></h3>
                                <div class="realisation-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                                <?php if ($tags && is_array($tags)) : ?>
                                    <div class="realisation-tags">
                                        <?php foreach ($tags as $tag) : ?>
                                            <span class="tag"><?php echo esc_html($tag); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($url) : ?>
                                    <a href="<?php echo esc_url($url); ?>"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="btn-link">
                                        <?php esc_html_e('Visiter le site', 'webmatic'); ?>
                                        <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                else : ?>
                    <p class="no-results"><?php esc_html_e('Aucune réalisation pour le moment.', 'webmatic'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Section Témoignages -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-header">
                <h2><?php esc_html_e('Avis Clients', 'webmatic'); ?></h2>
                <p><?php esc_html_e('Ce que disent mes clients', 'webmatic'); ?></p>
            </div>

            <div class="testimonials-grid">
                <?php
                $testimonials = new WP_Query(array(
                    'post_type'      => 'testimonial',
                    'posts_per_page' => 6,
                    'orderby'        => 'rand',
                    'no_found_rows'  => true,
                ));

                if ($testimonials->have_posts()) :
                    while ($testimonials->have_posts()) :
                        $testimonials->the_post();
                        $rating      = (int) (get_post_meta(get_the_ID(), 'testimonial_rating', true) ?: 5);
                        $rating      = max(1, min(5, $rating)); // Clamp entre 1 et 5
                        $author_info = get_post_meta(get_the_ID(), 'testimonial_author_info', true);
                        $initial     = esc_html(mb_substr(get_the_title(), 0, 1));
                        ?>
                        <div class="testimonial-card" data-testid="testimonial-card-<?php echo esc_attr(get_the_ID()); ?>">
                            <div class="testimonial-header">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="testimonial-avatar">
                                        <?php the_post_thumbnail('webmatic-testimonial', array('loading' => 'lazy')); ?>
                                    </div>
                                <?php else : ?>
                                    <div class="testimonial-avatar testimonial-avatar-initial" aria-hidden="true">
                                        <?php echo $initial; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="testimonial-author">
                                    <h4><?php the_title(); ?></h4>
                                    <?php if ($author_info) : ?>
                                        <p class="author-info"><?php echo esc_html($author_info); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="testimonial-rating" aria-label="<?php echo esc_attr(sprintf(__('Note : %d sur 5', 'webmatic'), $rating)); ?>">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <i class="<?php echo ($i <= $rating) ? 'fas' : 'far'; ?> fa-star" aria-hidden="true"></i>
                                <?php endfor; ?>
                            </div>
                            <div class="testimonial-content">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                else : ?>
                    <p class="no-results"><?php esc_html_e('Aucun témoignage pour le moment.', 'webmatic'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Section Contact -->
    <section class="contact-section">
        <div class="container">
            <div class="section-header">
                <h2><?php esc_html_e('Contactez-moi', 'webmatic'); ?></h2>
                <p><?php esc_html_e("N'hésitez pas à me contacter pour discuter de votre projet", 'webmatic'); ?></p>
            </div>

            <div class="contact-grid">
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h3><?php esc_html_e('Téléphone', 'webmatic'); ?></h3>
                            <a href="tel:<?php echo esc_attr(str_replace(' ', '', get_theme_mod('webmatic_phone', '0756913061'))); ?>">
                                <?php echo esc_html(get_theme_mod('webmatic_phone', '07 56 91 30 61')); ?>
                            </a>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h3><?php esc_html_e('Email', 'webmatic'); ?></h3>
                            <a href="mailto:<?php echo esc_attr(get_theme_mod('webmatic_email', 'contact@web-matic.fr')); ?>">
                                <?php echo esc_html(get_theme_mod('webmatic_email', 'contact@web-matic.fr')); ?>
                            </a>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h3><?php esc_html_e("Zone d'intervention", 'webmatic'); ?></h3>
                            <p><?php echo esc_html(get_theme_mod('webmatic_address', 'Pommier (69) et région Rhône-Alpes')); ?></p>
                        </div>
                    </div>

                    <?php $hours = get_theme_mod('webmatic_hours'); if ($hours) : ?>
                        <div class="contact-hours">
                            <h3><?php esc_html_e("Horaires d'ouverture", 'webmatic'); ?></h3>
                            <?php echo wp_kses_post($hours); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="contact-form">
                    <h3><?php esc_html_e('Envoyez-moi un message', 'webmatic'); ?></h3>
                    <?php echo do_shortcode('[webmatic_contact_form]'); ?>
                </div>
            </div>
        </div>
    </section>

                <?php
            endif; // End Elementor check
        endwhile;
    endif;
    ?>

</main>

<?php get_footer(); ?>