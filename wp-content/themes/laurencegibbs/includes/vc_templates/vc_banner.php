<?php
vc_map( array(
    "name" => __("Inside Banner"),
    "base" => "lg_inside_banner",
    "category" => __('Content'),
    'icon' => 'icon-wpb-single-image',
    'description' => 'Banner for the inside pages',
    "params" => array(
        array(
            "type" => "attach_image",
            "heading" => __("Banner Image"),
            "param_name" => "image",
        )
    )
));
add_shortcode('lg_inside_banner', 'insideBanner');
function insideBanner($atts) {
    $args = shortcode_atts( array(
        'image' => ''
    ), $atts);
    $image = $args['image'];
    $img = wp_get_attachment_image_src($image, 'banner');
    $id = get_the_ID();
    $html = '
    <div class="inside-banner-wrapper">
        <img src="' . $img[0] . '" alt="" />
        <div class="page-title"><h1>' . get_the_title($id) . '</h1></div>
    </div>';

    return $html;
}