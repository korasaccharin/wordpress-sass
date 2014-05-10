<?php
/*
 * Plugin Name: SASS
 * Plugin URI:  https://github.com/korasaccharin/wp-sass
 * Description: SASS support for WordPress. Automated SASS stylesheets generation. Based on Ed Burns's plugin
 * Version:     1.0.1
 * Author:      Kora Saccharin
 * Author URI:  http://www.kora-saccharin.com
 * License:     GPL2
 */

require_once(plugin_dir_path(__FILE__) . 'phpsass/SassParser.php');
require_once(plugin_dir_path(__FILE__) . 'sass_stylesheet.php');

function wpsass_register_style($handle, $src, $deps=array(), $ver=null, $media='all')
{
    $stylesheet = wpsass_generate_style($src);
    if (!$stylesheet) return null;
    $version    = isset($ver) ? $ver : $stylesheet->version();
    wp_register_style($handle, $stylesheet->uri(), $deps, $version, $media);
}
function wpsass_enqueue_style($handle, $src, $deps=array(), $ver=null, $media='all')
{
    $stylesheet = wpsass_generate_style($src);
    if (!$stylesheet) return null;
    $version    = isset($ver) ? $ver : $stylesheet->version();
    wp_enqueue_style($handle, $stylesheet->uri(), $deps, $version, $media);
}
function wpsass_generate_style($src)
{
    $stylesheet = new SASS_Stylesheet($src);

    # $stylesheet->debug_mode = true;

    if (!$stylesheet->is_valid()) return false;
    if (!$stylesheet->is_uptodate()) $stylesheet->compile();

    return $stylesheet;
}