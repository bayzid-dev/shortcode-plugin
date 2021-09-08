<?php
/**
 * Plugin Name: shortcode generator of theme
 * Plugin Uri: https://word-counter
 * Description:  This plugin can count any wordpress post's total word
 * Author:  sejan ahmed bayzid
 * Version: 1.0
 * License: 
 * Text Domain: shortcode
 * Domain path: /language 
 */

// loading text domain
function shortcode_load_textdomain()
{
    load_plugin_textdomain( "shortcode", false, dirname(__FILE__) . "/languages");
}
add_action("plugin_loaded", "shortcode_load_textdomain");


// return -> should be used in sprintf
function shortcode_button( $attributes )
{
    return sprintf(
        '<a href="%s" target="_blank" class="btn btn-%s btn-%s">%s</a>',
        $attributes[ 'url' ],
        $attributes[ 'type' ],
        $attributes[ 'size' ],
        $attributes[ 'title' ],
    );
}
add_shortcode( 'button', 'shortcode_button' );  // first param of add_shortcode is the name of shortcode which will be written on the post tag 

// gmap shortcode
function google_map_shortcode( $attributes ){

    $default = array (
        'place' => 'Brahmanbaria',
        'width' => '800',
        'height' => '600',
        'zoom' => '14'
    );
    $params = shortcode_atts( $default, $attributes );
    $map =  <<<EOD
        <div>
            <div>
                <iframe width="{$params['width']}" height="{$params['height']}"
                    src="https://maps.google.com/maps?q={$params['place']}&t=&z={$params['zoom']}&ie=UTF8&iwloc=&output=embed"
                    frameborder="0" scrolling='no' marginheight="0" marginwidth="0">
                </iframe>
            </div>
        </div>
    EOD;  
    return $map;
}
add_shortcode( 'gmap', 'google_map_shortcode' );

/* 
* quick tags for gmap and button
*/
function shortcode_quicktags( $screen ){
    if ( 'post.php' == $screen ) {
        wp_enqueue_script( 'quicktags_js', plugin_dir_url(__FILE__) . "assets/js/quicktags.js", array( 'quicktags', 'thickbox' ));
    }
}
add_action('admin_enqueue_scripts', 'shortcode_quicktags');
