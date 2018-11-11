jQuery(function($) {
    var $ = jQuery;
    $('.top').click(function(event){
        $('html, body').animate({
            scrollTop: 0
        }, 500);
        return false;
    });
    var waypoint = new Waypoint({
        element: document.getElementById('header'),
        handler: function() {
            $(".top").toggleClass('show');
        },
        offset: -500
    });
    gallerySlick = $(".gallery-slideshow-wrapper").slick({
        centerMode: true,
        centerPadding: '5px',
        slidesToShow: 3,
        nextArrow: '<i class="fa fa-angle-right"></i>',
        prevArrow: '<i class="fa fa-angle-left"></i>',
        dots: false,
        responsive: [
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 2
                }
            }
        ],
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1
                }
            }
        ],
    });
    $(".home-cta.weddings").click(function() {
        window.location.href = "/gallery/weddings/";
    });
    $(".home-cta.engagements").click(function() {
        window.location.href = "/gallery/engagement/";
    });
});
