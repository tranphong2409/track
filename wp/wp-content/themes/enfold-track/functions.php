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

global $wp;
$current_url = home_url(add_query_arg(array(),$wp->request));
if($_SERVER['REQUEST_URI'] == '/vi/'){
    wp_redirect( '/vi/trang-chu/' );
    exit;
}

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

function get_zone(){
    global $wpdb;
    $zones = $wpdb->get_results( 'SELECT DISTINCT name FROM wp_track_zones ORDER BY name', OBJECT );
    return $zones;
}

function slideshow_shortcode() {
    $zones = get_zone();
    $zone_option= '';
    foreach($zones as $zone){
        $zone_option .= '<option value="'.$zone->name.'">'.$zone->name.'</option>';
    }
    return '
        <div class="track">
            <button>'.__("Track & Trace").'</button>
            <div class="input-field">
                <input class="text-box" type="text" placeholder="'.__("Enter your tracking number").'" />
            </div>
        </div>
        <div class="quote" >
            <form action="" id="quote-form">
                <div class="input-field">
                    <select class="text-box" name="dest">
                        <option value="">'.__("Destination").'</option>
                        ' . $zone_option . '
                    </select>
                    <input class="text-box" type="text" name="weight" placeholder="'.__("Weight").'" />
                    <select class="text-box" name="type">
                        <option value="1">'.__("Document").'</option>
                        <option value="2">'.__("Parcel").'</option>
                    </select>
                </div>
                <button id="bt_get_quote">'.__("Get a Quote").'</button>
            </form>
        </div>
    ';
}
add_shortcode('home_slideshow', 'slideshow_shortcode');

function quote_shortcode(){
    $zones = get_zone();
    $zone_option= '';
    foreach($zones as $zone){
        $zone_option .= '<option value="'.$zone->name.'">'.$zone->name.'</option>';
    }
    return '
    <div class="quote">
        <form action="" id="quote-form">
            <div class="input-field">
                    <select class="text-box" name="dest">
                        <option value="">'.__("Destination").'</option>
                        ' . $zone_option . '
                    </select>
                    <input class="text-box" type="text" name="weight" placeholder="'.__("Weight").'" />
                    <select class="text-box" name="type">
                        <option value="1">'.__("Document").'</option>
                        <option value="2">'.__("Parcel").'</option>
                    </select>
            </div>
            <button id="bt_get_quote">'.__("Get a Quote").'</button> <span style="padding-left:20px"> <i class="yellow"> * </i> '.__("Your detail will be maintained confidentially").'</span>
            </form>
        </div>
    ';
}
add_shortcode('quote_box', 'quote_shortcode');

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
    wp_register_script( 'avia-google-maps-api', $prefix.'://maps.google.com/maps/api/js?key=AIzaSyAvq5JDRU0w1Hu9vNidS4Hpq0jVeZS9Twg', array('jquery'), '3', true);
    wp_enqueue_script('avia-google-maps-api');
}
add_action('init', 'ava_googlemaps_apikey');



function vcomment_list_func( $atts ) {
    $a = shortcode_atts( array(
        'id' => [8,9],
    ), $atts );
    $args = array(
        'posts_per_page'   => 5,
        'offset'           => 0,
        'category'         => $a['id'],
        'category_name'    => '',
        'orderby'          => 'date',
        'order'            => 'DESC',
        'include'          => '',
        'exclude'          => '',
        'meta_key'         => '',
        'meta_value'       => '',
        'post_type'        => 'post',
        'post_mime_type'   => '',
        'post_parent'      => '',
        'author'	   => '',
        'author_name'	   => '',
        'post_status'      => 'publish',
        'suppress_filters' => true
    );
    $posts_array = new WP_Query( $args );
    $html = '<div class="v_list">';
    foreach($posts_array->posts as $post){
        $thum_image = wp_get_attachment_image_src ( get_post_thumbnail_id($post->ID),array(260,185),false );
        $time = strtotime($post->post_date);
        $html .='<div class="item">
                    <div class="fea-img img'.$post->ID.'">
                        <a href="'.get_permalink($post->ID).'" ><img src="'.$thum_image[0].'" alt="" /></a>
                        <span class="month">'.date('M',$time).'</span>
                        <span class="date">'.date('d',$time).'</span>
                    </div>
                    <div class="item-content">
                        <h3 class="title"><a href="'.get_permalink($post->ID).'" >'.$post->post_title.'</a></h3>
                        <div id="content'.$post->ID.'">'.apply_filters('the_excerpt', $post->post_excerpt).'</div>
                        <a class="readmore" href="'.get_permalink($post->ID).'">'.__("Read more").'</a>
                    </div>
                    <div class="clr"></div>
                 </div>';
    }
    $html .='</div>';
    return $html;
}
add_shortcode( 'v_lists', 'vcomment_list_func' );

add_filter( 'dynamic_sidebar_params', 'b3m_wrap_widget_titles', 20 );
function b3m_wrap_widget_titles( array $params ) {

    // $params will ordinarily be an array of 2 elements, we're only interested in the first element
    $widget =& $params[0];
    $widget['before_title'] = '<h4 class="widgettitle"><span class="sidebar-title">';
    $widget['after_title'] = '</span></h4>';

    return $params;

}

add_filter('wp_list_categories', 'cat_count_span');
function cat_count_span($links) {
    $links = str_replace('</a> (', ' <span>', $links);
    $links = str_replace(')', '</span></a>', $links);
    return $links;
}
/* This code filters the Archive widget to include the post count inside the link */
add_filter('get_archives_link', 'archive_count_span');
function archive_count_span($links) {
    $links = str_replace('</a>&nbsp;(', '<span> ', $links);
    $links = str_replace(')', '</span></a>', $links);
    return $links;
}

//ajax

function wpdocs_theme_name_scripts() {
    wp_enqueue_script( 'my-script', get_stylesheet_directory_uri() . '/script.js', array('jquery'), '1.0.0', true );
    wp_localize_script( 'my-script', 'ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );


add_action( 'wp_ajax_get_price_by_filter', 'get_price_by_filter' );
add_action( 'wp_ajax_nopriv_get_price_by_filter', 'get_price_by_filter' );

function get_price_by_filter(){
    $args = $_POST['args'];
    $data = array(
       'error'=> false,
       'txt' => '',
       'dest' => $args['dest'],
       'weight' => $args['weight'] ? $args['weight'] . ' Kg' : $args['weight'],
       'type' => $args['type'] == 1 ? __('Document') : __('Parcel') ,
       'val' => null
    );
    if($args['dest'] == "" || $args['weight'] == "" || $args['type'] ==""){
        $data['txt'] = "something went wrong, please try again later";
        $data['error'] = true;
    }else{
        $args['weight'] > 2 ? $args['type'] = 2 : $args['type'] = 1;
        $data['val'] = get_zone_info($args['dest'],$args['weight'],$args['type']);
    }
    echo json_encode($data);
    die();
}


function get_zone_info($zone_name,$weight,$type){
    global $wpdb;
    $results = null;
    if($zone_name && $weight && $type){
        $query = "SELECT DISTINCT p.*,z.day_time, s.name FROM wp_track_price as p JOIN wp_track_zones as z ON z.group_id = p.group_id AND z.service_type = p.services_id JOIN wp_track_services as s ON s.id = p.services_id "
                ."WHERE z.name LIKE '".$zone_name."' AND p.kg_min < ".$weight." AND p.kg_max >= ".$weight ." AND p.goods_id = ".$type;
        $results = $wpdb->get_results( $query, OBJECT );
    }
    return $results;
}

?>
