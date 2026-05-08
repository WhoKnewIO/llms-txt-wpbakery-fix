<?php
/**
 * Plugin Name: LLMs.txt WPBakery Fix
 * Description: Strips WPBakery shortcodes from content before it is captured by the website-llms-txt plugin, preventing raw shortcode output in llms.txt files.
 * Version: 1.0.0
 * Author: WhoKnew™
 * Author URI: https://whoknew.io
 */

function ccla_strip_wpbakery_for_llms( $description, $post ) {
    if ( empty( $description ) ) {
        $content = $post->post_content;
        // Strip all shortcodes
        $content = strip_shortcodes( $content );
        // Strip any leftover shortcode fragments
        $content = preg_replace( '/\[[^\]]+\]/', '', $content );
        // Strip HTML tags
        $content = wp_strip_all_tags( $content );
        // Clean up excess whitespace
        $content = preg_replace( '/\s+/', ' ', $content );
        $description = trim( substr( $content, 0, 200 ) );
    }
    return $description;
}
add_filter( 'llms_generator_get_post_meta_description', 'ccla_strip_wpbakery_for_llms', 10, 2 );
