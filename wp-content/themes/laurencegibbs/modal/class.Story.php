<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/14/2018
 * Time: 9:16 PM
 */
class Story extends LGBase
{
    public function getFeatureImage()
    {
        return $this->getPostMeta('feature-image');
    }
    public function getBannerImage()
    {
        return $this->getPostMeta('banner-image');
    }
    public function getSnippet()
    {
        $content = wpautop($this->getPostMeta('snippet'));
        return $content;
    }
    public function getTestimonial()
    {
        $content = wpautop($this->getPostMeta('testimonial'));
        return $content;
    }
    public function getGalleryImages()
    {
        $gallery = Array();
        $field = get_post_meta($this->id());
        foreach($field['wpcf-gallery-images'] as $image) {
            $gallery[] = $image;
        }
        return $gallery;
    }
    public function getCategory()
    {
        global $wpdb;
        // get the stories associated with this gallery
        $sql = 'SELECT parent_id FROM ' . $wpdb->prefix . 'toolset_associations WHERE child_id = ' . $this->Post->ID;
        $result = $wpdb->get_results($sql);

        return new Gallery($result[0]->parent_id);
    }
    public function previous()
    {
        global $wpdb;
        $gallery = $this->getCategory();
        $sql = '
        SELECT p.ID
        FROM ' . $wpdb->prefix . 'posts p
        INNER JOIN ' . $wpdb->prefix . 'toolset_associations ta
        ON p.ID = ta.child_id
        WHERE p.ID < ' . $this->Post->ID . '
        AND post_status="publish" AND post_type="story" LIMIT 1';
        $result = $wpdb->get_results($sql);

        return new Story($result[0]->ID);
    }
    public function next()
    {
        global $wpdb;
        $gallery = $this->getCategory();
        $sql = '
        SELECT p.ID 
        FROM ' . $wpdb->prefix . 'posts p
        INNER JOIN ' . $wpdb->prefix . 'toolset_associations ta
        ON p.ID = ta.child_id
        WHERE p.ID > ' . $this->Post->ID . '
        AND post_status="publish" AND post_type="story" LIMIT 1';
        $result = $wpdb->get_results($sql);

        return new Story($result[0]->ID);
    }
}