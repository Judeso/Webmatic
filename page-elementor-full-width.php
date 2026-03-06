<?php
/**
 * Template Name: Elementor Full Width
 * Description: Template pleine largeur pour Elementor sans marges du thème
 *
 * @package WebMatic
 */

get_header();
?>

<main id="main" class="site-main elementor-full-width" role="main">
    <?php
    while (have_posts()) :
        the_post();
        the_content();
    endwhile;
    ?>
</main>

<?php
// Footer optionnel - peut être désactivé via page meta si besoin
if (!get_post_meta(get_the_ID(), '_hide_footer', true)) {
    get_footer();
} else {
    wp_footer();
    ?>
    </body>
    </html>
    <?php
}
