<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 
// Add "custom CSS" field for Enfold builder elements
add_theme_support('avia_template_builder_custom_css');

//first append search item to main menu
add_filter( 'wp_nav_menu_items', 'avia_append_search_nav', 10, 2 );
add_filter( 'avf_fallback_menu_items', 'avia_append_search_nav', 10, 2 );

function avia_append_search_nav ( $items, $args )
{
    if(avia_get_option('header_searchicon','header_searchicon') != "header_searchicon") return $items;
    if(avia_get_option('header_position',  'header_top') != "header_top") return $items;

    if ((is_object($args) && $args->theme_location == 'avia') || (is_string($args) && $args = "fallback_menu"))
    {
        global $avia_config;
        ob_start();
        get_search_form();
        $form =  ob_get_clean() ;

        $items .= '<li class="noMobile"><div class="search-form">'.$form.'</div></li>';
    }
    return $items;
}

function slideshow_shortcode() {
    return '
        <div class="track">
            <button>Track & Trace</button>
            <div class="input-field">
                <input class="text-box" type="text" placeholder="Enter your tracking number" />
            </div>
        </div>
        <div class="quote">
            <div class="input-field">
                <input class="text-box" type="text" placeholder="Destination" />
                <input class="text-box" type="text" placeholder="Weight" />
                <input class="text-box" type="text" placeholder="Document" />
            </div>
            <button>Get a Quote</button>
        </div>
    ';
}
add_shortcode('home_slideshow', 'slideshow_shortcode');

function slideshow2_shortcode() {
    return '
        <div class="track">
            <button>Track & Trace</button>
            <div class="input-field">
                <input class="text-box" type="text" placeholder="Enter your tracking number" />
            </div>
        </div>
        <div class="quote">
            <div class="input-field">
                <input class="text-box" type="text" placeholder="Destination" />
                <input class="text-box" type="text" placeholder="Weight" />
                <input class="text-box" type="text" placeholder="Document" />
            </div>
            <button>Get a Quote</button>
        </div>
    ';
}
add_shortcode('_slideshow', 'slideshow2_shortcode');

add_shortcode( 'bread_crumb', 'avia_title' );

// remove title
add_filter('avf_title_args', function($args) {
    $args['html']  = "<div class='{class} title_container'><div class='container'>{additions}</div></div>";
    return $args;
});

function ava_googlemaps_apikey() {
    $prefix  = is_ssl() ? "https" : "http";
    wp_deregister_script('avia-google-maps-api');
    wp_register_script( 'avia-google-maps-api', $prefix.'://maps.google.com/maps/api/js?key=AIzaSyAidX34J-pkIHmOUFdVrt05MpzDHz-VZUk', array('jquery'), '3', true);
    wp_enqueue_script('avia-google-maps-api');
}
add_action('init', 'ava_googlemaps_apikey');

?>
