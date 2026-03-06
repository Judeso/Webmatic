<?php
/**
 * Template principal
 * 
 * @package WebMatic
 */

get_header(); ?>

<main id="main" class="site-main" role="main">
    <div class="container">
        <div class="content-area">
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
                    get_template_part('template-parts/content', get_post_type());
                endwhile;
                
                // Pagination
                the_posts_pagination(array(
                    'prev_text' => __('&laquo; Précédent', 'webmatic'),
                    'next_text' => __('Suivant &raquo;', 'webmatic'),
                ));
            else :
                ?>
                <div class="no-results">
                    <h1><?php _e('Aucun contenu trouvé', 'webmatic'); ?></h1>
                    <p><?php _e('Désolé, aucun contenu ne correspond à votre recherche.', 'webmatic'); ?></p>
                </div>
                <?php
            endif;
            ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>