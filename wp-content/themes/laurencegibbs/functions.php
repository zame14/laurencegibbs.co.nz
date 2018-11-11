<?php
require_once('modal/class.Base.php');
require_once('modal/class.Story.php');
require_once('modal/class.Gallery.php');
add_action( 'wp_enqueue_scripts', 'p_enqueue_styles');
function p_enqueue_styles() {
    wp_enqueue_style( 'bootstrap-css', get_stylesheet_directory_uri() . '/css/bootstrap.min.css?' . filemtime(get_stylesheet_directory() . '/css/bootstrap.min.css'));
    wp_enqueue_style( 'font-awesome', get_stylesheet_directory_uri() . '/css/font-awesome.min.css?' . filemtime(get_stylesheet_directory() . '/css/font-awesome.css'));
    wp_enqueue_style( 'google_font_open_sans', 'https://fonts.googleapis.com/css?family=Open+Sans:400,600');
    wp_enqueue_style( 'google_font_raleway', 'https://fonts.googleapis.com/css?family=Raleway:400,600');
    wp_enqueue_style( 'google_font_karla', 'https://fonts.googleapis.com/css?family=Karla:400,700');
    wp_enqueue_style( 'slick', get_stylesheet_directory_uri() . '/slick-carousel/slick/slick.css');
    wp_enqueue_style( 'understrap-theme', get_stylesheet_directory_uri() . '/style.css?' . filemtime(get_stylesheet_directory() . '/style.css'));
    wp_enqueue_script('bootstrap-js', get_stylesheet_directory_uri() . '/js/bootstrap.min.js?' . filemtime(get_stylesheet_directory() . '/js/bootstrap.min.js'), array('jquery'));
    wp_enqueue_script( 'waypoint', get_stylesheet_directory_uri() . '/js/noframework.waypoints.min.js');
    wp_enqueue_script('understap-theme', get_stylesheet_directory_uri() . '/js/theme.js?' . filemtime(get_stylesheet_directory() . '/js/theme.js'), array('jquery'));
    wp_enqueue_script( 'masonry', get_stylesheet_directory_uri() . '/masonry-layout/dist/masonry.pkgd.js');
    wp_enqueue_script( 'slick', get_stylesheet_directory_uri() . '/slick-carousel/slick/slick.js');
}
function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_image_size( 'feature', 575, 575, true);
add_image_size( 'banner', 2000 );
add_image_size( 'gallery', 767 );
add_image_size( 'story', 1200 );
add_image_size( 'category', 900, 600, true );

// Remove unwanted theme page templates

function dg_remove_page_templates( $templates ) {

    unset( $templates['page-templates/blank.php'] );

    unset( $templates['page-templates/right-sidebarpage.php'] );

    unset( $templates['page-templates/both-sidebarspage.php'] );

    unset( $templates['page-templates/empty.php'] );

    unset( $templates['page-templates/fullwidthpage.php'] );

    unset( $templates['page-templates/left-sidebarpage.php'] );

    unset( $templates['page-templates/right-sidebarpage.php'] );

    return $templates;

}

add_filter( 'theme_page_templates', 'dg_remove_page_templates' );

function getStories() {
    $stories = Array();
    $posts_array = get_posts([
        'post_type' => 'story',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby' => 'ID',
        'order' => 'DESC',
        'meta_query' => [
            [
                'key' => 'wpcf-feature',
                'value' => 1
            ]
        ]
    ]);
    foreach ($posts_array as $post) {
        $story = new Story($post);
        $stories[] = $story;
    }
    return $stories;
}

function getGalleries() {
    $galleries = Array();
    $posts_array = get_posts([
        'post_type' => 'gallery',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby' => 'ID',
        'order' => 'ASC'
    ]);
    foreach ($posts_array as $post) {
        $gallery = new Gallery($post);
        $galleries[] = $gallery;
    }
    return $galleries;
}

function featureStories_shortcode() {
    $stories = getStories();
    shuffle($stories);
    $i = 1;
    $html = '
    <div class="stories-wrapper row">';
    foreach ($stories as $story) {
        $imageid = getImageID($story->getFeatureImage());
        $img = wp_get_attachment_image_src($imageid, 'feature');
        $html .= '
        <div class="col-6 col-lg-3 story-tile">
            <a href="' . $story->link() . '">
                <div class="image-wrapper">
                    <img src="' . $img[0] . '" alt="' . $story->getTitle() . '" />
                </div>
                <div class="title">
                    ' . $story->getTitle() . '
                </div>
            </a>
        </div>';
        if($i == 4) break;
        $i++;
    }
    $html .= '
    </div>';

    return $html;
}
add_shortcode('feature_stories', 'featureStories_shortcode');

function stories_shortcode() {
    $stories = getStories();
    $html = '
    <div class="stories-wrapper row">';
    foreach ($stories as $story) {
        $imageid = getImageID($story->getFeatureImage());
        $img = wp_get_attachment_image_src($imageid, 'feature');
        $html .= '
        <div class="col-6 col-sm-6 col-md-6 col-lg-3 story-tile">
            <a href="' . $story->link() . '">
                <div class="image-wrapper">
                    <img src="' . $img[0] . '" alt="' . $story->getTitle() . '" />
                </div>
                <div class="title">
                    ' . $story->getTitle() . '
                </div>
            </a>
        </div>';
    }
    $html .= '
    </div>';

    return $html;
}
add_shortcode('stories', 'stories_shortcode');

function template_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Footer Widget', 'understrap' ),
        'id'            => 'footerwidget',
        'description'   => 'Widget area in the footer',
        'before_widget'  => '<div class="footer-widget-wrapper">',
        'after_widget'   => '</div><!-- .footer-widget -->',
        'before_title'   => '<h3 class="widget-title">',
        'after_title'    => '</h3>',
    ) );
}
add_action( 'widgets_init', 'template_widgets_init' );

add_action('admin_init', 'my_general_section');
function my_general_section() {
    add_settings_section(
        'my_settings_section', // Section ID
        'Custom Website Settings', // Section Title
        'my_section_options_callback', // Callback
        'general' // What Page?  This makes the section show up on the General Settings Page
    );

    add_settings_field( // Option 1
        'phone', // Option ID
        'Phone Number', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed (General Settings)
        'my_settings_section', // Name of our section
        array( // The $args
            'phone' // Should match Option ID
        )
    );

    add_settings_field( // Option 2
        'email', // Option ID
        'Email', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed
        'my_settings_section', // Name of our section (General Settings)
        array( // The $args
            'email' // Should match Option ID
        )
    );

    add_settings_field( // Option 2
        'address', // Option ID
        'Address', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed
        'my_settings_section', // Name of our section (General Settings)
        array( // The $args
            'address' // Should match Option ID
        )
    );

    add_settings_field( // Option 2
        'facebook', // Option ID
        'Facebook Link', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed
        'my_settings_section', // Name of our section (General Settings)
        array( // The $args
            'facebook' // Should match Option ID
        )
    );

    add_settings_field( // Option 2
        'instagram', // Option ID
        'Instagram Link', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed
        'my_settings_section', // Name of our section (General Settings)
        array( // The $args
            'instagram' // Should match Option ID
        )
    );

    register_setting('general','phone', 'esc_attr');
    register_setting('general','email', 'esc_attr');
    register_setting('general','address', 'esc_attr');
    register_setting('general','facebook', 'esc_attr');
    register_setting('general','instagram', 'esc_attr');
}

function my_section_options_callback() { // Section Callback
    echo '';
}

function my_textbox_callback($args) {  // Textbox Callback
    $option = get_option($args[0]);
    echo '<input type="text" id="'. $args[0] .'" name="'. $args[0] .'" value="' . $option . '" />';
}

function formatPhoneNumber($ph) {
    $ph = str_replace('(', '', $ph);
    $ph = str_replace(')', '', $ph);
    $ph = str_replace(' ', '', $ph);
    $ph = str_replace('+64', '0', $ph);

    return $ph;

}
function socialMediaMenu() {
    $html = '
    <ul class="social-media">';
    if(get_option('facebook')) {
        $html .= '<li><a href="' . get_option('facebook') . '" target="_blank" class="fa fa-facebook-square"></a>';
    }
    if(get_option('instagram')) {
        $html .= '<li><a href="' . get_option('instagram') . '" target="_blank" class="fa fa-instagram"></a>';
    }
    $html .= '</ul>';

    return $html;
}

function galleryMenu() {
    $html = '
    <ul class="gallery-menu">';
    foreach (getGalleries() as $gallery) {
        $html .= '<li><span class="fa fa-camera-retro"></span><a href="' . $gallery->link() . '">' . $gallery->getTitle() . '</a></li>';
    }
    $html .= '
    </ul>';

    return $html;
}
function getImageID($image_url)
{
    global $wpdb;
    $sql = 'SELECT ID FROM ' . $wpdb->prefix . 'posts WHERE guid = "' . $image_url . '"';
    $result = $wpdb->get_results($sql);

    return $result[0]->ID;
}