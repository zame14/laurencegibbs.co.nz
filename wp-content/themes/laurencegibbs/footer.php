<a class="top">
    <span class="fa fa-chevron-up"></span>
</a>
<section id="instagram-feed">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 nopadding">
                <?php
                if(is_active_sidebar('footerwidget')){
                dynamic_sidebar('footerwidget');
                }
                ?>
            </div>
        </div>
    </div>
</section>
<section id="footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-5">
                <h3>Contact</h3>
                <ul class="contacts">
                    <li><span class="fa fa-phone"></span><a href="tel:<?=formatPhoneNumber(get_option('phone'))?>"><?=get_option('phone')?></a></li>
                    <li><span class="fa fa-envelope"></span><a href="mailto:<?=get_option('email')?>"><?=get_option('email')?></a></li>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 gallery-menu-col">
                <h3>Galleries</h3>
                <?=galleryMenu()?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 social-media-col">
                <h3>Follow</h3>
                <?=socialMediaMenu()?>
            </div>
        </div>
    </div>
</section>
<section id="copyright">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                &copy; Copyright <?=date('Y')?> <?=get_bloginfo('name')?> <i>-</i> <span>Website by <a href="https://www.azwebsolutions.co.nz/" target="_blank">A-Z Web Solutions Ltd</a></span>
            </div>
            <div class="col-xl-12">
                <a href="<?=get_page_link(199)?>" class="sitemap">Sitemap</a>
            </div>
        </div>
    </div>
</section>
<?php wp_footer(); ?>
</body>
</html>