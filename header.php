<?php
/**
 * En-tête du thème
 *
 * @package WebMatic
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Font Awesome - Force load -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#main">
        <?php esc_html_e( 'Aller au contenu', 'webmatic' ); ?>
    </a>

    <header id="masthead" class="site-header" role="banner">
        <div class="header-container">

            <!-- Logo / Titre -->
            <div class="site-branding">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <?php if ( is_front_page() ) : ?>
                        <h1 class="site-title">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <?php bloginfo( 'name' ); ?>
                            </a>
                        </h1>
                    <?php else : ?>
                        <p class="site-title">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <?php bloginfo( 'name' ); ?>
                            </a>
                        </p>
                    <?php endif; ?>
                    <?php
                    $description = get_bloginfo( 'description' );
                    if ( $description ) : ?>
                        <p class="site-description"><?php echo esc_html( $description ); ?></p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <!-- Navigation principale -->
            <nav id="site-navigation"
                 class="main-navigation"
                 role="navigation"
                 aria-label="<?php esc_attr_e( 'Menu principal', 'webmatic' ); ?>">

                <button class="menu-toggle"
                        aria-controls="primary-menu"
                        aria-expanded="false"
                        aria-label="<?php esc_attr_e( 'Ouvrir le menu', 'webmatic' ); ?>">
                    <span class="menu-toggle-icon" aria-hidden="true"></span>
                    <span class="screen-reader-text"><?php esc_html_e( 'Menu', 'webmatic' ); ?></span>
                </button>

                <?php
                wp_nav_menu( array(
                    'theme_location'  => 'primary',
                    'menu_id'         => 'primary-menu',
                    'container'       => 'div',
                    'container_class' => 'menu-primary-container',
                    'fallback_cb'     => false,
                ) );
                ?>
            </nav>

            <!-- Actions header -->
            <div class="header-actions">
                <?php
                $phone         = get_theme_mod( 'webmatic_phone', '07 56 91 30 61' );
                $phone_clean   = str_replace( ' ', '', $phone );
                $devis_page_id = get_theme_mod( 'webmatic_devis_page' );
                ?>
                <a href="tel:<?php echo esc_attr( $phone_clean ); ?>" class="btn-phone">
                    <i class="fas fa-phone" aria-hidden="true"></i>
                    <span><?php echo esc_html( $phone ); ?></span>
                </a>

                <?php if ( $devis_page_id ) : ?>
                    <a href="<?php echo esc_url( get_permalink( $devis_page_id ) ); ?>" class="btn-devis">
                        <?php esc_html_e( 'Devis gratuit', 'webmatic' ); ?>
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </header>

    <div id="content" class="site-content">