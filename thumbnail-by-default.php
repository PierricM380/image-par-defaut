<?php

/**
 * Plugin Name:    Image Par Défaut
 * Plugin URI:     https://github.com/PierricM380/thumbnail-by-default 
 * Description:    Image par défaut va vous permettra de choisir une image pour vos articles. Rendez-vous dans l'onglet "Apparence" -> "Personnaliser" -> 
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
 * Return post HTML with default image
 *
 * @param   string  $html
 * @param   int     $post_id
 * @param   int     $thumbnail id
 * @param   string  $size
 * @param   array   $attributes
 * @return  string  $html
 * 
 */
function thumbnail_by_default_html($html, $post_id, $thumbnail_id, $size, $attr)
{
    $post_type = get_post_type($post_id);
    if (empty($html) && !$thumbnail_id && in_array($post_type, array('post', 'page'))) {
        $default_id = get_option("default_${post_type}_thumbnail");
        $html       = wp_get_attachment_image($default_id, $size, false, $attr);
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
 * @param bool             $has_thumbnail
 * @param int|WP_Post|null $post
 * @param int|false        $thumbnail_id
 * 
 */
function thumbnail_by_default_has_post_thumbnail($has_thumbnail, $post, $thumbnail_id)
{
    $post_type = get_post_type($post);
    if (!$thumbnail_id && in_array($post_type, array('post', 'page'))) {
        return (bool) get_option("default_${post_type}_thumbnail");
    }
    return $has_thumbnail;
}

/**
 * Setting into theme customizer
 * https://developer.wordpress.org/themes/customize-api/customizer-objects/
 * Use instance of customize_register hook
 */

add_action('customize_register', 'thumbnail_by_default_customize_register');
/**
 * Add parameters options into theme configuration panel
 *
 * @param $wp_customize
 */
function thumbnail_by_default_customize_register($wp_customize)
{
    $wp_customize->add_section('thumbnail', array(
        'title' => __('Image par défaut', 'thumbnail-by-default'),
    ));
    $wp_customize->add_setting('default_post_thumbnail', array(
        'type'              => 'option',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'default_post_thumbnail', array(
        'label'     => __('Choisir une image pour vos articles', 'thumbnail-by-default'),
        'section'   => 'thumbnail',
        'mime_type' => 'image',
    )));
    $wp_customize->add_setting('default_page_thumbnail', array(
        'type'              => 'option',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'default_page_thumbnail', array(
        'label'     => __('Choisir une image pour vos pages', 'thumbnail-by-default'),
        'section'   => 'thumbnail',
        'mime_type' => 'image',
    )));
}
