<?php
/**
 * Pied de page du thème - Layout Horizontal
 * 
 * @package WebMatic
 */
?>
    </div><!-- #content -->
    
    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="footer-main">
            <div class="container">
                <div class="footer-horizontal">
                    
                    <!-- Logo & Description -->
                    <div class="footer-brand">
                        <?php if (has_custom_logo()) : ?>
                            <div class="footer-logo">
                                <?php the_custom_logo(); ?>
                            </div>
                        <?php else : ?>
                            <h3 class="footer-site-title"><?php bloginfo('name'); ?></h3>
                        <?php endif; ?>
                        <p class="footer-tagline"><?php bloginfo('description'); ?></p>
                    </div>
                    
                    <!-- Navigation Footer -->
                    <div class="footer-nav">
                        <h4><?php _e('Navigation', 'webmatic'); ?></h4>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'menu_id'        => 'footer-menu',
                            'container'      => false,
                            'fallback_cb'    => false,
                            'depth'          => 1,
                        ));
                        ?>
                    </div>
                    
                    <!-- Contact Info -->
                    <div class="footer-contact-info">
                        <h4><?php _e('Contact', 'webmatic'); ?></h4>
                        <ul class="contact-list-horizontal">
                            <?php if ($phone = get_theme_mod('webmatic_phone')) : ?>
                            <li>
                                <i class="fas fa-phone"></i>
                                <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>">
                                    <?php echo esc_html($phone); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            
                            <?php if ($email = get_theme_mod('webmatic_email')) : ?>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:<?php echo esc_attr($email); ?>">
                                    <?php echo esc_html($email); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            
                            <?php if ($address = get_theme_mod('webmatic_address')) : ?>
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?php echo esc_html($address); ?></span>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    
                    <!-- Social Links -->
                    <?php if (get_theme_mod('webmatic_show_social', true)) : ?>
                    <div class="footer-social">
                        <h4><?php _e('Suivez-nous', 'webmatic'); ?></h4>
                        <div class="social-icons">
                            <?php if ($facebook = get_theme_mod('webmatic_facebook')) : ?>
                            <a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <?php endif; ?>
                            
                            <?php if ($twitter = get_theme_mod('webmatic_twitter')) : ?>
                            <a href="<?php echo esc_url($twitter); ?>" target="_blank" rel="noopener" aria-label="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <?php endif; ?>
                            
                            <?php if ($linkedin = get_theme_mod('webmatic_linkedin')) : ?>
                            <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <?php endif; ?>
                            
                            <?php if ($instagram = get_theme_mod('webmatic_instagram')) : ?>
                            <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-horizontal">
                    <div class="copyright">
                        <?php
                        $copyright_text = get_theme_mod('webmatic_copyright_text', sprintf(
                            __('&copy; %s %s. Tous droits réservés.', 'webmatic'),
                            date('Y'),
                            get_bloginfo('name')
                        ));
                        echo wp_kses_post($copyright_text);
                        ?>
                    </div>
                    
                    <nav class="footer-legal-nav">
                        <a href="<?php echo esc_url(home_url('/mentions-legales')); ?>">
                            <?php _e('Mentions légales', 'webmatic'); ?>
                        </a>
                        <span class="separator">|</span>
                        <a href="<?php echo esc_url(home_url('/politique-confidentialite')); ?>">
                            <?php _e('Politique de confidentialité', 'webmatic'); ?>
                        </a>
                        <span class="separator">|</span>
                        <a href="<?php echo esc_url(home_url('/rgpd')); ?>">
                            <?php _e('RGPD', 'webmatic'); ?>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>