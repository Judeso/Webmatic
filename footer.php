<?php
/**
 * Pied de page du thème
 * 
 * @package WebMatic
 */
?>
    </div><!-- #content -->
    
    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="footer-widgets">
            <div class="container">
                <div class="footer-columns">
                    <?php if (is_active_sidebar('footer-1')) : ?>
                    <div class="footer-column">
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (is_active_sidebar('footer-2')) : ?>
                    <div class="footer-column">
                        <?php dynamic_sidebar('footer-2'); ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (is_active_sidebar('footer-3')) : ?>
                    <div class="footer-column">
                        <?php dynamic_sidebar('footer-3'); ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="footer-column footer-contact">
                        <h3><?php _e('Contact', 'webmatic'); ?></h3>
                        <ul class="contact-info">
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
                                <?php echo esc_html($address); ?>
                            </li>
                            <?php endif; ?>
                        </ul>
                        
                        <?php if (get_theme_mod('webmatic_show_social', true)) : ?>
                        <div class="social-links">
                            <?php if ($facebook = get_theme_mod('webmatic_facebook')) : ?>
                            <a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener" aria-label="Facebook">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <?php endif; ?>
                            
                            <?php if ($twitter = get_theme_mod('webmatic_twitter')) : ?>
                            <a href="<?php echo esc_url($twitter); ?>" target="_blank" rel="noopener" aria-label="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <?php endif; ?>
                            
                            <?php if ($linkedin = get_theme_mod('webmatic_linkedin')) : ?>
                            <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener" aria-label="LinkedIn">
                                <i class="fab fa-linkedin"></i>
                            </a>
                            <?php endif; ?>
                            
                            <?php if ($instagram = get_theme_mod('webmatic_instagram')) : ?>
                            <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <div class="copyright">
                        <?php
                        $copyright_text = get_theme_mod('webmatic_copyright_text', sprintf(
                            __('&copy; %s WebMatic. Tous droits réservés.', 'webmatic'),
                            date('Y')
                        ));
                        echo wp_kses_post($copyright_text);
                        ?>
                    </div>
                    
                    <?php
                    if (has_nav_menu('footer')) {
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'menu_id'        => 'footer-menu',
                            'container'      => 'nav',
                            'container_class' => 'footer-navigation',
                            'depth'          => 1,
                        ));
                    }
                    ?>
                </div>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>