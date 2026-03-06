<?php
/**
 * Template pour les articles
 *
 * @package WebMatic
 */

get_header();
?>

<main id="main" class="site-main" role="main">
    <div class="container">
        <div class="single-content">
            <?php
            while (have_posts()) :
                the_post();

                // Vérifier si Elementor gère ce contenu
                if (!function_exists('elementor_theme_do_location') || !elementor_theme_do_location('single')) :
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>

                        <div class="entry-meta">
                            <span class="posted-on">
                                <i class="far fa-calendar"></i>
                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                    <?php echo esc_html(get_the_date()); ?>
                                </time>
                            </span>
                            <span class="byline">
                                <i class="far fa-user"></i>
                                <?php the_author(); ?>
                            </span>
                            <?php if (has_category()) : ?>
                            <span class="cat-links">
                                <i class="far fa-folder"></i>
                                <?php the_category(', '); ?>
                            </span>
                            <?php endif; ?>
                        </div>
                    </header>

                    <?php if (has_post_thumbnail()) : ?>
                    <div class="entry-thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php
                        the_content();

                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . __('Pages:', 'webmatic'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>

                    <?php if (has_tag()) : ?>
                    <footer class="entry-footer">
                        <div class="tags-links">
                            <i class="fas fa-tags"></i>
                            <?php the_tags('', ', ', ''); ?>
                        </div>
                    </footer>
                    <?php endif; ?>
                </article>

                <div class="post-navigation">
                    <?php
                    the_post_navigation(array(
                        'prev_text' => '<span class="nav-subtitle">' . __('Précédent:', 'webmatic') . '</span> <span class="nav-title">%title</span>',
                        'next_text' => '<span class="nav-subtitle">' . __('Suivant:', 'webmatic') . '</span> <span class="nav-title">%title</span>',
                    ));
                    ?>
                </div>

                <?php
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;

                endif; // End Elementor check
            endwhile;
            ?>
        </div>

        <?php get_sidebar(); ?>
    </div>
</main>

<?php get_footer(); ?>