<?php
/**
 * Template pour les pages
 *
 * @package WebMatic
 */

get_header(); ?>

<main id="main" class="site-main" role="main">
    <div class="container">
        <div class="page-content">
            <?php
            while ( have_posts() ) :
                the_post();
            ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) : ?>

                        <header class="entry-header">
                            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                        </header>

                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="entry-thumbnail">
                                <?php the_post_thumbnail( 'large', array( 'loading' => 'eager' ) ); ?>
                            </div>
                        <?php endif; ?>

                        <div class="entry-content">
                            <?php
                            the_content();

                            wp_link_pages( array(
                                'before' => '<div class="page-links">' . __( 'Pages :', 'webmatic' ),
                                'after'  => '</div>',
                            ) );
                            ?>
                        </div>

                    <?php endif; ?>

                </article>

                <?php if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;

            endwhile;
            ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>