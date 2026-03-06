<?php
/**
 * Lazy Loading des images
 *
 * @package WebMatic
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function webmatic_lazy_loading( $content ) {
    if ( empty( $content ) ) return $content;

    return preg_replace_callback(
        '/<img([^>]+)>/i',
        function( $matches ) {
            // Ne pas modifier si loading est déjà présent
            if ( strpos( $matches[1], 'loading=' ) !== false ) {
                return $matches[0];
            }
            return '<img' . $matches[1] . ' loading="lazy">';
        },
        $content
    );
}
add_filter( 'the_content', 'webmatic_lazy_loading' );
