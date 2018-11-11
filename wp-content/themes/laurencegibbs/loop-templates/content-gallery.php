<?php
$gallery = new Gallery($post);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <!-- .entry-header -->
    <div>
        <header class="entry-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12 nopadding">
                        <div class="inside-banner-wrapper">
                            <img src="<?=$gallery->getBannerImage()?>" alt="<?=$gallery->getTitle()?>" />
                            <div class="page-title"><h1><?=$gallery->getTitle()?></h1></div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="entry-content">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 page-intro">
                        <?=$gallery->getContent()?>
                    </div>
                </div>
            </div>
            <div class="gallery-wrapper">
                <div class="gallery-slideshow-wrapper">
                    <?php
                    foreach ($gallery->getGalleryImages() as $image) {
                        $imageid = getImageID($image);
                        $img = wp_get_attachment_image_src($imageid, 'category');
                        echo '
                        <div>
                            <img src="' . wp_make_link_relative($img[0]) . '" alt="" />
                        </div>';
                    }
                    ?>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xs-12 col-lg-8 m-nopadding">
                        <?=$gallery->getCTA()?>
                    </div>
                </div>
            </div>
            <div class="page-navigation-section">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12">
                            <?=$gallery->next()?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>
