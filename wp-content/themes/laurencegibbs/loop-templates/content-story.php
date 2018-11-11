<?php
$story = new Story($post);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <!-- .entry-header -->
    <div>
        <header class="entry-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12 nopadding">
                        <div class="inside-banner-wrapper">
                            <img src="<?=$story->getBannerImage()?>" alt="<?=$story->getTitle()?>" />
                            <div class="page-title"><h1><?=$story->getTitle()?></h1></div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="entry-content">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 page-intro">
                        <?=$story->getSnippet()?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <?=$story->getContent()?>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="story-images-wrapper">
                            <?php
                            foreach($story->getGalleryImages() as $images) {
                                $imageid = getImageID($images);
                                $img = wp_get_attachment_image_src($imageid, 'story');
                                echo '<div class="story-image"><img src="' . wp_make_link_relative($img[0]) . '" alt="" /></div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if($story->getTestimonial() <> "") { ?>
                <div class="testimonials-wrapper">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-xs-12 col-lg-10">
                                <?=$story->getTestimonial()?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
            <div class="page-navigation-section">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12">
                            <?php
                            $previous = $story->previous();
                            if($previous->id() <> "") {
                                echo '<a href="' . $previous->link() . '" class="previous">' . $previous->getTitle() . '</a>';
                            }
                            echo '<a href="' . get_page_link(83) . '" class="listing"><span class="fa fa-th"></span></a>';
                            $next = $story->next();
                            if($next->id() <> "") {
                                echo '<a href="' . $next->link() . '" class="next">' . $next->getTitle() . '</a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    //lightbox
    $slides = count($story->getGalleryImages());
    $p = 1;
    $m = 1;
    echo '
    <div id="galleryModal" class="modal">
        <span class="fa fa-times" onclick="closeModal()"></span>
        <input type="hidden" name="viewed" class="viewed" value="" />
        <div class="modal-content">';
        foreach($story->getGalleryImages() as $images) {
            echo '
            <div class="slides slide' . $m . '">
                <div class="navtext">' . $story->getTitle() . ' - ' . $m . ' / ' . $slides . '</div>
                <img src="' . wp_make_link_relative($images) . '" alt="" />
            </div>';
            $m++;
        }
        echo '
        <a class="prev fa fa-angle-left" onclick="plusSlides(-1)"></a>
        <a class="next fa fa-angle-right" onclick="plusSlides(1)"></a>';
        echo '      
        </div>
    </div>';
    ?>
</article>
