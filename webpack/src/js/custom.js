
jQuery(document).ready(function($) {

    if($('.wps-products').size() > 0) {
        $('.wps-products').addClass("content-wrapper-section");
        $('.wps-products').removeClass('wps-contain');
    }

    if(window.location.pathname === '/products/') {

    }

    if($(window).width() < 1367) {
        var img308 = $('.wp-image-308').clone(true);
        $('.about-page-text-box.align-right.top').prepend(img308);
        $('.about-page-image.align-left .wp-image-308').remove();

        var img310 = $('.wp-image-310').clone(true);
        $('.about-page-text-box.align-left.middle').prepend(img310);
        $('.about-page-image.align-right .wp-image-310').remove();

        var img311 = $('.wp-image-311').clone(true);
        $('.about-page-text-box.align-right.bot').prepend(img311);
        $('.about-page-image.align-left .wp-image-311').remove();

    }

    if($(window).width() < 640) {
        var img = $('#home-section-about .fw-row:nth-of-type(2) img').clone(true);
        $('#home-section-about .fw-row:nth-of-type(2) .fw-col-sm-9 p:nth-of-type(1)').prepend(img);
        $('#home-section-about .fw-row:nth-of-type(2) .fw-col-sm-3 img').remove();

        //
        /*var img310 = $('.wp-image-310').clone(true);
        $('.about-page-text-box.align-right.top').append(img310);
        $('.about-page-image.align-right .wp-image-310').remove();

        var img308 = $('.wp-image-308').clone(true);
        $('.about-page-text-box.align-right.top').prepend(img308);
        $('.about-page-image.align-left .wp-image-308').remove();*/

        $('.home-services-items, .home-discover-items').addClass('mobile_content_slider');


        var service = $('.blog-sinle-page-container .service-date').clone(true);
        $('.blog-single-header').prepend(service);
        $('.blog-sinle-page-container .service-date').remove();

        if($('.has-icon').size() > 0) {
            $('.has-icon').prepend('<span class="icon-container"></span>');
        }

        $('.mobile-category-current').removeClass('hidden');
    }

    var style = $('.single-product-header h1').attr('style');

    $('.single-product--form label').on('style', style);

    $('input[name="billing_first_name"]').val(localStorage.getItem('firstName'));
    $('input[name="billing_last_name"]').val(localStorage.getItem('lastName'));
    $('input[name="billing_email"]').val(localStorage.getItem('userEmail'));

    if($('.slider-discover').size() > 0) {
        $('.slider-discover').bxSlider({
            pager: true,
            auto: true,
            pause: 10000
        });
    }


        $('.slider-reviews-on-service').bxSlider();

        var widthSlide = 3,
            slideWidth = 311;

        if( $(window).width() < 640 ){
            widthSlide = 1;
        }else if($(window).width() > 640 && $(window).width() < 769){
            widthSlide = 2;
            slideWidth = 361;
        }

        $('.slider-books').bxSlider({
            minSlides: 1,
            maxSlides: widthSlide,
            moveSlides: 1,
            slideWidth: ( $(window).width() < 640 ) ? 413 : slideWidth
        });

        $('.slider-reviews').bxSlider({
            minSlides: 1,
            maxSlides: widthSlide,
            moveSlides: 1,
            slideWidth: slideWidth
        });

    $('.carousel-discover').bxSlider({
        pager: false,
        /*slideMargin: 5,*/
        minSlides: 2,
        maxSlides: widthSlide,
        moveSlides: 1,
        slideWidth: 336
    });

    $('.bx-next').html('<img src="/wp-content/themes/numeralogy/assets/img/right-arrow.svg" alt="next" />');
    $('.bx-prev').html('<img src="/wp-content/themes/numeralogy/assets/img/left-arrow.svg" alt="previews" />');

    $('.arrow-black .bx-next').html('<img src="/wp-content/themes/numeralogy/assets/img/right-arrow-black.svg" alt="next" />');
    $('.arrow-black .bx-prev').html('<img src="/wp-content/themes/numeralogy/assets/img/left-arrow-black.svg" alt="previews" />');

    $('.mobile_content_slider').bxSlider();



    $(".gak").on("click", function (event) {

        event.preventDefault();

        var id  = $(this).attr('href'),

        top = $(id).offset().top;

        $('body,html').animate({scrollTop: top}, 1500);

    });

    $('.service-book').click(function(){
        var ServiceName = $(this).data('name');

        setTimeout(function(){
            $('input.service-name').val(ServiceName);
            $('#eModal-2 .emodal-title').text(ServiceName);
        }, 300);

    });

/* Personal Number Profile */
    $('#wpcf7-f227-p37-o1  form').on('submit', function(e) {
        e.preventDefault();
        var arrName = [];

        var id    = $('.single-product--form').data('id');
        var name  = $('input[name="np-name"]').val();
        var email = $('input[name="np-email"]').val();
        var month = $('input[name="np-month"]').val();
        var day   = $('input[name="np-day"]').val();
        var year  = $('input[name="np-year"]').val();


        localStorage.setItem('userEmail', email);

        if(name.indexOf(' ')) {

            arrName = name.split(' ');

            localStorage.setItem('firstName', arrName[0]);
            localStorage.setItem('lastName', arrName[1]);
        }
        else {
            localStorage.setItem('firstName', name);
        }

        $.ajax({
            method: 'post',
            url: '/wp-admin/admin-ajax.php',
            data: { action: 'numerology_profile_answer',
                    'product_id': id,
                    'name': name,
                    'email': email,
                    'month': month,
                    'day': day,
                    'year': year
            },
            success: function(data) {
                if(data === "fail")
                    return false;
                window.location.href = data;
            }
        });
        return false;
    });
    var style = $('.single-product-header h1').attr('style');
    $('#single-product-change-selector').attr('style', style);

    /* Astrology Profile */
    $('#wpcf7-f229-p217-o1 form').on('submit', function(e) {
        e.preventDefault();

        var id    = $('.single-product--form').data('id');
        var astrology_sign = $('select[name="menu-929"]').val();
        var gender = $('select[name="menu-930"]').val();
        var email  = $('input[name="your-email"]').val();

        $.ajax({
            method: 'post',
            url: '/wp-admin/admin-ajax.php',
            data: {
                'action': 'astrology_profile_answer',
                'product_id': id,
                'email': email,
                'astrology_sign': astrology_sign,
                'gender': gender
            },
            success: function(data) {
                if(data === "fail")
                    return false;
                window.location.href = data;
            }
        });
    });

    /* Marriage Date */
    $('#wpcf7-f231-p74-o1 form').on('submit', function(e) {
        e.preventDefault();

        var id    = $('.single-product--form').data('id');
        var email = $('input[name="email-842"]').val();
        var month = $('input[name="number-32"]').val();
        var day   = $('input[name="number-33"]').val();
        var year  = $('input[name="number-34"]').val();

        localStorage.setItem('userEmail', email);
        localStorage.setItem('firstName', '');
        localStorage.setItem('lastName', '');

        $.ajax({
            method: 'post',
            url: '/wp-admin/admin-ajax.php',
            data: {
                'action': 'marriage_date_answer',
                'product_id': id,
                'email': email,
                'month': month,
                'day': day,
                'year': year
            },
            success: function(data) {
                if(data === "fail")
                    return false;
                window.location.href = data;
            }
        });
    });

    $('#wpcf7-f233-p76-o1 form').on('submit', function(e) {
        e.preventDefault();

        var id    = $('.single-product--form').data('id');
        var email = $('input[name="email-133"]').val();
        var number = $('select[name="select-number"]').val();

        localStorage.setItem('userEmail', email);
        localStorage.setItem('firstName', '');
        localStorage.setItem('lastName', '');

        $.ajax({
            method: 'post',
            url: '/wp-admin/admin-ajax.php',
            data: {
                'action': 'jersey_number_answer',
                'product_id': id,
                'email': email,
                'number': number
            },
            success: function(data) {
                if(data === "fail")
                    return false;
                window.location.href = data;
            }
        });
    });

    $('.single-product--form .wpcf7-response-output').remove();

    $('.search-icon-block').on('click', function() {
        $(this).hide();
        $('.search-form').show(200);
        $('.input-search').animate({width: '100%'}, 400, "linear");
    });

    $('.input-close').on('click', function() {
        $('.search-form').hide();
        $('.search-icon-block').show(200);
    });

    $('.blog-item--social-info .social').on('click', function() {
        $(this).next('.social-sharing-btn').fadeToggle('slow');
    });

    $('.blog-item--social-info .karma').on('click', function() {
        $(this).next('span.like-block').fadeToggle('slow');
    });


    $('.social-sharing a').on('click', function() {

        var post_id = $(this).closest('.social-sharing-btn').data('id');
        var elem = $(this);
        var urlPost = $(this).closest('div.blog-item-info-box').find('.blog-item--title-box a').attr('href');
        var socialType = $(this).attr('class');
        var popup = ss_plugin_loadpopup_js(this);

        var timer = setInterval(function(){
            console.log(popup.closed);
            if(popup.closed){

                clearInterval(timer);

                $.ajax({
                    method: 'post',
                    url: '/wp-admin/admin-ajax.php',
                    data: {
                        'action': 'increment_social_count',
                        'post_id': post_id,
                        'social_btn': socialType,
                        'post_url': urlPost
                    },
                    success: function(data) {
                        elem.closest('.blog-item--social-info').find('.social').html(data);
                    }
                });
            }
        }, 1000);

    });

    $('.like-block').on("click", function() {
        var post_like_id = $(this).data('id');
        var elem = $(this);

        $.ajax({
            method: 'post',
            url: '/wp-admin/admin-ajax.php',
            data: {
                'action': 'increment_like_count',
                'post_like_id': post_like_id
            },
            success: function(data) {
                if(data === 'fail') {
                    $('span.like-block').fadeOut('slow');
                    alert("You can vote for the post only once!");

                    return false;
                }
                elem.closest('.blog-item--social-info').find('.karma').html(data);
            }
        });
    });

    $('.eModal-1').on('click', function() {
        $('#eModal-1 input[type="text"]').val('');
        $('#eModal-1 input[type="email"]').val('');
        $('#eModal-1 input[type="tel"]').val('');
        $('#eModal-1 textarea').val('');
        $('span[role="alert"]').remove();
    });

    $('.eModal-2').on('click', function() {
        $('#eModal-2 input[type="text"]').val('');
        $('#eModal-2 input[type="email"]').val('');
        $('#eModal-2 input[type="tel"]').val('');
        $('#eModal-2 textarea').val('');
        $('span[role="alert"]').remove();
    });

    $('.cat-blog-btn-toggle').on('click', function(e) {
        e.preventDefault();

        $('.category-blog-items').slideToggle(350);
    });

});