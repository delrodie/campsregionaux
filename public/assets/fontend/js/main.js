$(document).ready(function () {


    if (('.filters-content').length > 0) {
        $('.filters-content').each(function () {
            $(this).magnificPopup({
                delegate: '.js-zoom-gallery',
                type: 'image',
                gallery: {
                    enabled: true
                }
            });
        });
    }

    $(window).on("scroll", function () {
        "use strict";
        var sections = $('section'),
            nav = $('.navbar-nav'),
            nav_height = nav.outerHeight() + 25;
        $(window).scrollTop() >= 20 ? $("nav").addClass("sticky-header") : $(".sticky").removeClass("sticky-header");
        /*----ON SCROLL CHANGE ACTIVE MENU-----*/
        var cur_pos = $(this).scrollTop();
        sections.each(function () {
            var top = $(this).offset().top - nav_height,
                bottom = top + $(this).outerHeight();
            if (cur_pos >= top && cur_pos <= bottom) {
                nav.find('li').removeClass('active');
                $(this).addClass('active');
                nav.find('a[href="#' + $(this).attr('id') + '"]').parent().addClass('active');
            }
        });
        /*----COUNTER-UP JS-----*/
        var a = 0;
        (function ($) {
            var length = $('#counter').length;
            if (length >= 1) {
                var oTop = $('#counter').offset().top - window.innerHeight;
                if (a == 0 && $(window).scrollTop() > oTop) {
                    $('.counter-value').each(function () {
                        var $this = $(this),
                            countTo = $this.attr('data-count');
                        $({
                            countNum: $this.text()
                        }).animate({
                            countNum: countTo
                        },
                            {
                                duration: 2000,
                                easing: 'swing',
                                step: function () {
                                    $this.text(Math.floor(this.countNum));
                                },
                                complete: function () {
                                    $this.text(this.countNum);
                                }
                            });
                    });
                    a = 1;
                }
            }

        })(jQuery);
    }), $(".one-page-scroll .nav-item a").on("click", function (o) {
        var t = $(this);
        $('.nav-item').removeClass('active');
        $(t).parent().addClass('active');
        $('body').removeClass('openmenu');
        $("html, body").stop().animate({
            scrollTop: $(t.attr("href")).offset().top - 50
        }, 1500, "easeInOutExpo"), o.preventDefault()
    }), $(document).on("click", ".navbar-collapse.show", function (o) {
        $(o.target).is("a") && $(this).collapse("hide")
    }), $(window).on("scroll", function () {
        $(this).scrollTop() > 100 ? $(".back_top").fadeIn() : $(".back_top").fadeOut()
    }), $(".back_top").on("click", function () {
        return $("html, body").animate({
            scrollTop: 0
        }, 1e3), !1
    });
    /*----MOBILE-MENU OVERLAY JS-----*/
    (function ($) {
        $('.navbar-toggler').on("click", function () {
            $('body').addClass('openmenu');
        });
        $('.menu-overlay').on("click", function () {
            $('body').removeClass('openmenu');
            $('.navbar-collapse').removeClass('show');
        });
    })(jQuery);
    /*----ACCORDIAN JS-----*/
    (function ($) {
        $(".accordion-card").click(function () {
            if ($(this).hasClass('active')) {
                $('.accordion-card').removeClass('active');
                $(this).removeClass('active')
            } else {
                $('.accordion-card').removeClass('active');
                $(this).addClass('active')
            }
        });
    })(jQuery);

});
/*----COUNTER-----*/
$.fn.jQuerySimpleCounter = function (options) {
    var settings = $.extend({
        start: 0,
        end: 100,
        easing: 'swing',
        duration: 400,
        complete: ''
    }, options);

    var thisElement = $(this);

    $({
        count: settings.start
    }).animate({
        count: settings.end
    }, {
        duration: settings.duration,
        easing: settings.easing,
        step: function () {
            var mathCount = Math.ceil(this.count);
            thisElement.text(mathCount);
        },
        complete: settings.complete
    });
};


$('#number1').jQuerySimpleCounter({
    end: 500,
    duration: 3000
});
$('#number2').jQuerySimpleCounter({
    end: 1000,
    duration: 3000
});
$('#number3').jQuerySimpleCounter({
    end: 50,
    duration: 2000
});
$('#number4').jQuerySimpleCounter({
    end: 8899,
    duration: 2500
});

/*----WOW ANIMATION-----*/
(function ($) {
    var length = $('.wow').length;
    if (length >= 1) {
        wow = new WOW({
            boxClass: 'wow',
            animateClass: 'animated',
            offset: 0,
        });
        wow.init();
    }
})(jQuery);
