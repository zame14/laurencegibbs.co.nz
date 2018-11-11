<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/15/2018
 * Time: 9:12 PM
 */
class Gallery extends LGBase
{
    public function getBannerImage()
    {
        return $this->getPostMeta('gallery-banner-image');
    }
    public function getCTAImage()
    {
        return $this->getPostMeta('cta-image');
    }
    public function getGalleryImages()
    {
        $gallery = Array();
        $field = get_post_meta($this->id());
        foreach($field['wpcf-category-gallery-images'] as $image) {
            $gallery[] = $image;
        }
        return $gallery;
    }
    public function getStories()
    {
        global $wpdb;
        // get the stories associated with this gallery
        $stories = array();
        $sql = 'SELECT child_id FROM ' . $wpdb->prefix . 'toolset_associations WHERE parent_id = ' . $this->Post->ID;
        $result = $wpdb->get_results($sql);
        foreach ($result as $item) {
            $stories[] = $item->child_id;
        }

        return $stories;
    }
    public function getCTA() {
        $html = '
        <div class="cta-wrapper">
            <div class="flex-item">
                <img src="' . $this->getPostMeta('cta-image') . '" alt="" />
            </div>
            <div class="flex-item">
                <div class="content-wrapper">
                    <div class="title">Capturing all your special and beautiful moments</div>
                    <a href="' . get_page_link(76) .'" class="btn btn-cta">Get Started</a>
                </div>
            </div>
        </div>';

        return $html;
    }
    public function next() {
        $html = '';
        foreach (getGalleries() as $gallery) {
            if($this->Post->ID <> $gallery->id()) {
                $html = '<a href="' . $gallery->link() . '" class="next">' . $gallery->getTitle() . '</a>';
                break;
            }
        }
        return $html;
    }
}