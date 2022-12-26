<?php

/**
 * Plugin Name:    Thumbnail By Default
 * Plugin URI:     https://github.com/PierricM380/thumbnail-by-default 
 * Description:    Thumbnail By Default va vous permettra de choisir une image par défaut pour votre article.
 * Version:        1.0.0
 * Author:         LuneDev66
 * Author URI:     https://pierricmaryedeveloppeurweb.netlify.app/
 * Livence:        GPL v2 or later
 * Text Domain:    thumbnail-by-default
 * Domain Path:    /languages
 */

/**
 * post_thumbnail_html -> Filters the post thumbnail HTML
 * apply_filters( 'post_thumbnail_html', $html, $post->ID, $post_thumbnail_id, $size, $attr );
 * https://developer.wordpress.org/reference/functions/get_the_post_thumbnail/
 */
add_filter('post_thumbnail_html', 'thumbnail_by_default_html', 10, 5);

/**
 * Return post HTML with image id
 *
 * @param $html
 * @param $post_id
 * @param $thumbnail_id
 * @param $size
 * @param $attr
 * @return void
 */
function thumbnail_by_default_html($html, $post_id, $thumbnail_id, $size, $attr)
{
    if (!empty($html) && !$thumbnail_id) {
        $html = wp_get_attachment_image(11, $size, false, $attr);
    }

    return $html;
}

/**
 * has_post_thumbnail -> Filters whether a post has a post thumbnail.
 * apply_filter('has_post_thumbnail', $has_thumbnail, $post, $thumbnail_id)
 */
add_filter('has_post_thumbnail', 'thumbnail_by_default_has_post_thumbnail', 10, 3);

/**
 * Always return true for an post image. Work only for articles.
 *
 * @param $has_thumbnail
 * @param $post
 * @param $thumbnail_id
 * @return void
 */
function thumbnail_by_default_has_post_thumbnail($has_thumbnail, $post, $thumbnail_id)
{
    if ('post' === get_post_type($post)) {
        $has_thumbnail = true;
    }

    return $has_thumbnail;
}

/**
 * Setting into theme customizer
 * https://developer.wordpress.org/themes/customize-api/customizer-objects/
 * Use instance of customize_register hook
 */

add_action('customize_register', 'thumbnail_by_default_customize_register', 10, 1);
function thumbnail_by_default_customize_register($wp_customize)
{
    $wp_customize->add_section( 'thumbnail_by_default_settings', array(
        'title' => __( 'Thumbnail By Default', 'thumbnail-by-default' ),
        'description' => __( 'Ajouter du CSS ici', 'thumbnail-by-default' ),
      ) );

      $wp_customize->add_setting( 'thumbnail_by_default_id', array(
        'type' => 'option', // or 'theme_mod'
        'default' => '',
        'sanitize_callback' => 'absint',
      ) );

      $wp_customize->add_control( 'thumbnail_by_default_id', array(
        'type' => 'number',
        'section' => 'thumbnail_by_default_settings',
        'label' => __( 'Image par défaut des articles', 'thumbnail-by-default' ),
        'description' => __( 'Entrer un identifiant de l\'image par défaut.', 'thumbnail-by-default' ),
      ) );
}
