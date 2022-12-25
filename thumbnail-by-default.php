<?php

/**
 * Plugin Name:    Thumbnail By Default
 * Plugin URI:
 * Description:    Thumbnail By Default va vous permettra de choisir une image par défaut pour votre article.
 * Version:        1.0.0
 * Author:         LuneDev66
 * Author URI:     https://pierricmaryedeveloppeurweb.netlify.app/
 * Livence:        GPL v2 or later
 * Text Domain:    thumbnail-by-default
 * Domain Path:    /languages
 */

/**
 * WordPress offers filter hooks to allow plugins to modify various types of internal data at runtime
 * apply_filters( 'post_thumbnail_html', $html, $post->ID, $post_thumbnail_id, $size, $attr );
 * https://developer.wordpress.org/reference/functions/get_the_post_thumbnail/
 */ 
add_filter('post_thumbnail_html', 'thumbnail_by_default_html', 10, 5);

/**
 * Undocumented function
 *
 * @param [type] $html
 * @param [type] $post_id
 * @param [type] $thumbnail_id
 * @param [type] $size
 * @param [type] $attr
 * @return void
 */
function thumbnail_by_default_html($html, $post_id, $thumbnail_id, $size, $attr)
{
    return $html;
}