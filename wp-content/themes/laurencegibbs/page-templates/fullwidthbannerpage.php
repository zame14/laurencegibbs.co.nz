<?php
/**
 * Template Name: Full Width Banner Page
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published and banner pulled from Feature Image.
 *
 * @package understrap
 */
get_header();
?>
<div class="wrapper" id="full-width-banner-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 nopadding">
                <div class="inside-banner-wrapper">
                    <?php echo get_the_post_thumbnail($post->ID, 'full'); ?>
                    <div class="page-title">
                        <?php the_title('<h1>', '</h1>'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container" id="content">

        <div class="row">

            <div class="col-xl-12 content-area" id="primary">

                <main class="site-main" id="main" role="main">

                    <?php while ( have_posts() ) : the_post(); ?>

                        <?php get_template_part( 'loop-templates/content', 'page' ); ?>

                        <?php
                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) :

                            comments_template();

                        endif;
                        ?>

                    <?php endwhile; // end of the loop. ?>

                </main><!-- #main -->

            </div><!-- #primary -->

        </div><!-- .row end -->

    </div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
