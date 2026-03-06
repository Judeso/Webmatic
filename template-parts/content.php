<?php
/**
 * Template part pour afficher le contenu des articles
 * 
 * @package WebMatic
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('content-article'); ?>>
    <header class="entry-header">
        <?php
        if (is_singular()) :
            the_title('<h1 class="entry-title">', '</h1>');
        else :
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        endif;
        ?>
        
        <?php if ('post' === get_post_type()) : ?>
        <div class="entry-meta">
            <span class="posted-on">
                <i class="far fa-calendar"></i>
                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                    <?php echo esc_html(get_the_date()); ?>
                </time>
            </span>
        </div>
        <?php endif; ?>
    </header>
    
    <?php if (has_post_thumbnail() && !is_singular()) : ?>
    <div class="entry-thumbnail">
        <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail('medium_large'); ?>
        </a>
    </div>
    <?php endif; ?>
    
    <div class="entry-content">
        <?php
        if (is_singular()) :
            the_content();
        else :
            the_excerpt();
            ?>
            <a href="<?php the_permalink(); ?>" class="read-more">
                <?php _e('Lire la suite', 'webmatic'); ?> <i class="fas fa-arrow-right"></i>
            </a>
            <?php
        endif;
        ?>
    </div>
</article>