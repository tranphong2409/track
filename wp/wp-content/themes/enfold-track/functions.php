<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

add_filter( 'auto_update_plugin', '__return_false' );
add_filter( 'auto_update_theme', '__return_false' );

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


/*
 * CUSTOM GLOBAL VARIABLES
 */



function get_zone(){
    global $wpdb;
    $zones = $wpdb->get_results( 'SELECT DISTINCT name FROM wp_track_zones ORDER BY name', OBJECT );
    return $zones;
}

function slideshow_shortcode() {
    $zones = get_zone();
    $zone_option= '';
    $sLang = pll_current_language();
    $sUrlLink = "/track-and-trace/";
    if($sLang === "vi"){
        $sUrlLink = "/vi/tra-cuu/";
    }
    // echo pll_current_language();die();
    foreach($zones as $zone){
        $zone_option .= '<option value="'.$zone->name.'">'.$zone->name.'</option>';
    }
    return '
        <div class="track">

            <button onClick="jQuery(\'#traceForm\').submit();">'.__("Track & Trace").'</button>
        <form id="traceForm" action="'.$sUrlLink.'" method="get">
            <div class="input-field">
                <input class="text-box" type="text" name="code" placeholder="'.__("Enter your tracking number").'" />
            </div>
            </form>
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
            <button id="bt_get_quote">'.__("Get a Quote").'</button> <span class="quote-note"> <i class="yellow"> * </i> '.__("Your detail will be maintained confidentially").'</span>
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

function getTrackingDetailItem($code)
{
    global $wpdb;
    $sql    = "select t.destination AS main_destination, t.origin AS main_origin, t.note, t.status AS main_status, t.username, t.code, t2.location AS location_item, t2.note AS note_item, t2.time, t2.status AS status_item from {$wpdb->prefix}tracking as t RIGHT JOIN {$wpdb->prefix}tracking_item AS t2 ON t.code = t2.code WHERE t.code = '{$code}' ORDER BY t2.ID ASC";
    //die($sql);
    return $wpdb->get_results($sql);
}

function track_shortcode() {
    
    $code = $_GET['code'];
    $info = getTrackingDetailItem($code);
    
    if(!isset($code) || empty($info)){
        return "We didn't find any matches for shipment number ".$code.". Please check your tracking number.";
    }
    
    $data = array(
        'code'  => $code,
        'info'  => $info
    );
    ob_start();
    set_query_var('data', $data);        
    get_template_part('template','track-and-trace');
    $code = ob_get_contents();
    ob_end_clean();
    
    return $code;
}
add_shortcode('track', 'track_shortcode');

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




function custom_post_type() {

// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Service', 'Post Type General Name', 'twentythirteen' ),
        'singular_name'       => _x( 'Service', 'Post Type Singular Name', 'twentythirteen' ),
        'menu_name'           => __( 'Service', 'twentythirteen' ),
        'parent_item_colon'   => __( 'Parent Service', 'twentythirteen' ),
        'all_items'           => __( 'All Services', 'twentythirteen' ),
        'view_item'           => __( 'View Service', 'twentythirteen' ),
        'add_new_item'        => __( 'Add New Service', 'twentythirteen' ),
        'add_new'             => __( 'Add New', 'twentythirteen' ),
        'edit_item'           => __( 'Edit Service', 'twentythirteen' ),
        'update_item'         => __( 'Update Service', 'twentythirteen' ),
        'search_items'        => __( 'Search Service', 'twentythirteen' ),
        'not_found'           => __( 'Not Found', 'twentythirteen' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
    );



// Set other options for Custom Post Type

    $args = array(
        'label'               => __( 'Service', 'twentythirteen' ),
        'description'         => __( 'Description', 'twentythirteen' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor',   'thumbnail' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */
        'rewrite' => array('slug' => 'Service'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'taxonomies'          => array( 'Service-type' ),
    );

    // Set other options for Custom Post Type


    // Registering your Custom Post Type
    register_post_type( 'Services', $args );

}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not
* unnecessarily executed.
*/

//add_action( 'init', 'custom_post_type', 0 );

function sm_custom_meta() {
    add_meta_box( 'sm_meta', __( 'Featured Posts', 'sm-textdomain' ), 'sm_meta_callback', 'post' );
}

function sm_meta_callback( $post ) {
    $featured = get_post_meta( $post->ID );
    ?>

    <p>
    <div class="sm-row-content">
        <label for="meta-checkbox">
            <input type="checkbox" name="meta-checkbox" id="meta-checkbox" value="yes" <?php if ( isset ( $featured['meta-checkbox'] ) ) checked( $featured['meta-checkbox'][0], 'yes' ); ?> />
            <?php _e( 'Featured this post', 'sm-textdomain' )?>
        </label>

    </div>
    </p>

<?php
}
add_action( 'add_meta_boxes', 'sm_custom_meta' );

/**
 * Saves the custom meta input
 */
function sm_meta_save( $post_id ) {

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'sm_nonce' ] ) && wp_verify_nonce( $_POST[ 'sm_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    // Checks for input and saves
    if( isset( $_POST[ 'meta-checkbox' ] ) ) {
        update_post_meta( $post_id, 'meta-checkbox', 'yes' );
    } else {
        update_post_meta( $post_id, 'meta-checkbox', '' );
    }

}
add_action( 'save_post', 'sm_meta_save' );

function vcomment_list_func( $atts ) {
    $a = shortcode_atts( array(
        'id' => array(8,9),
    ), $atts );
    $args = array(
        'posts_per_page'   => 5,
        'offset'           => 0,
        'category__in'      => $a['id'],
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


function feature_list_func (){
    $args = array(
        'posts_per_page' => 7,
        'meta_key' => 'meta-checkbox',
        'meta_value' => 'yes'
    );
    $featured = new WP_Query($args);
    $i = 0;
    $total = count($featured->posts);
    ob_start();
    foreach($featured->posts as $post){
        if($i < 3) {
    ?>
        <div class="flex_column av_one_fourth   <?php if($i == 0) { ?>el_before_av_one_fourth el_after_av_hr first<?php } ?> ">
            <div style="padding-bottom:10px;" class="av-special-heading av-special-heading-h6">
                <h6 class="av-special-heading-tag" itemprop="headline"> <?php echo $post->post_title ?></h6>
                <div class="special-heading-border">
                    <div class="special-heading-inner-border"></div>
                </div>
            </div>
            <div style="height:40px" class="hr hr-invisible el_after_av_heading  el_before_av_textblock  ">
                <span class="hr-inner "><span class="hr-inner-style"></span></span>
            </div>
            <section class="av_textblock_section" itemscope="itemscope" itemtype="https://schema.org/CreativeWork">
                <div class="avia_textblock " itemprop="text">
                    <p><?php echo apply_filters('the_excerpt', $post->post_excerpt) ?></p>
                    <p style="text-align: right;"><a class="yellow read-more" href="<?php echo get_permalink($post->ID); ?>">View more -&gt;</a></p>
                </div>
            </section>
        </div>
    <?php
    }else{
            if($i == 3){
    ?>
                <div class="flex_column av_one_fourth   avia-builder-el-91  el_after_av_one_fourth  avia-builder-el-last  ">
                    <section class="av_textblock_section" itemscope="itemscope" itemtype="https://schema.org/CreativeWork">
                        <div class="avia_textblock " itemprop="text">
                            <ul style="margin-top:45px;">
                <?php   } ?>
                                <li><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title ?></a></li>
           <?php if(($i < 5 && $i == $total - 1) || $i == 5 ) { ?>
                            </ul>
                        </div>
                    </section>
                    <?php }

            if ($i == 6){?>
                    <div class="avia-button-wrap avia-button-right  avia-builder-el-93  el_after_av_textblock  avia-builder-el-last  ">
                        <a href="#" class="avia-button  avia-icon_select-no avia-color-theme-color avia-size-small avia-position-right ">
                            <span class="avia_iconbox_title">More News</span>
                        </a>
                    </div>
                    <?php } if($i == $total - 1){ ?>
                </div>
            <?php
                }
            }
        $i++;
    }
    return ob_get_clean();
}

add_shortcode( 'feature_list', 'feature_list_func' );

//add_filter('wp_trim_excerpt', function($text){
//    $max_length = 140;
//
//    if(mb_strlen($text, 'UTF-8') > $max_length){
//        $split_pos = mb_strpos(wordwrap($text, $max_length), "\n", 0, 'UTF-8');
//        $text = mb_substr($text, 0, $split_pos, 'UTF-8')."[...]";
//    }
//
//    return $text;
//});

/*
 * Menu shortcode
 *
 *
 * */

function print_menu_shortcode($atts) {
    $a = shortcode_atts( array(
        'name' => 'main-menu',
    ), $atts );
    return wp_nav_menu( array( 'menu' => $a['name'], 'echo' => false ) );
}
add_shortcode('menu', 'print_menu_shortcode');



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

function remove_menus(){

    remove_menu_page( 'index.php' );                  //Dashboard
    remove_menu_page( 'edit-comments.php' );          //Comments
    // remove_menu_page( 'plugins.php' );                //Plugins
//    remove_menu_page( 'users.php' );                  //Users
    remove_menu_page( 'tools.php' );                  //Tools
//    remove_menu_page( 'widgets.php' );                  //Tools
    remove_submenu_page( 'themes.php', 'widgets.php' );
//    remove_submenu_page( 'themes.php', 'nav-menus.php' );
    remove_submenu_page( 'themes.php', 'themes.php' );
    remove_submenu_page( 'themes.php', 'themes.php?page=install-required-plugins' );
    remove_menu_page( 'options-general.php' );        //Settings
    remove_menu_page( 'admin.php?page=avia' );        //slider
    remove_menu_page( 'admin.php?page=mlang' );        //lang
    remove_menu_page( 'admin.php?page=layerslider' );        //layerslider
    remove_menu_page( 'edit.php?post_type=portfolio' );        //portfolio
//    $submenu = $GLOBALS[ 'menu' ];
    
    
}
add_action( 'admin_menu', 'remove_menus' );

function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/logo.gif);
            height: 87px;
            width: 150px;
            background-size: 100%;
            background-repeat: no-repeat;
            padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

?>
