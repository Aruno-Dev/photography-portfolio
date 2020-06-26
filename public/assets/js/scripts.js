$(document).ready(function() {
    'use strict';
    /*-----------------------------------------------------------------------------------*/
    /*	STICKY HEADER
    /*-----------------------------------------------------------------------------------*/
    if ($(".navbar").length) {
        var options = {
            offset: 350,
            offsetSide: 'top',
            classes: {
                clone: 'banner--clone fixed',
                stick: 'banner--stick',
                unstick: 'banner--unstick'
            },
            onStick: function() {
                $($.SmartMenus.Bootstrap.init);
            },
            onUnstick: function() {
                $('.navbar .btn-group').removeClass('open');
            }
        };
        var banner = new Headhesive('.navbar', options);
    }
    /*-----------------------------------------------------------------------------------*/
    /*	HAMBURGER MENU ICON
    /*-----------------------------------------------------------------------------------*/
	$(".hamburger.animate").on( "click", function() {
        $(".hamburger.animate").toggleClass("active");
    });
    $('.onepage .navbar .nav li a').on('click', function() {
        $('.navbar .navbar-collapse.show').collapse('hide');
        $('.hamburger.animate').removeClass('active');
    });
    /*-----------------------------------------------------------------------------------*/
    /*	SWIPER
    /*-----------------------------------------------------------------------------------*/
    $(".basic-slider").each(function(index, element) {
        var $this = $(this);
        $this.find(".swiper-container").addClass("basic-slider-" + index);
        $this.find(".swiper-button-prev").addClass("btn-prev-" + index);
        $this.find(".swiper-button-next").addClass("btn-next-" + index);
        $this.find(".swiper-pagination").addClass("basic-slider-pagination-" + index);
        var swiper1 = new Swiper(".basic-slider-" + index, {
            slidesPerView: 1,
            spaceBetween: 0,
            autoHeight: true,
            grabCursor: true,
            pagination: {
                el: ".basic-slider-pagination-" + index,
                clickable: true,
            },
            navigation: {
                nextEl: ".btn-next-" + index,
                prevEl: ".btn-prev-" + index
            }
        });
    });
    $(".swiper-col4").each(function(index, element) {
        var $this = $(this);
        $this.find(".swiper-container").addClass("swiper-col4-" + index);
        $this.find(".swiper-button-prev").addClass("btn-prev-" + index);
        $this.find(".swiper-button-next").addClass("btn-next-" + index);
        $this.find(".swiper-pagination").addClass("swiper-col4-pagination-" + index);
        var swiper4 = new Swiper(".swiper-col4-" + index, {
            slidesPerView: 1,
            breakpoints: {
				768: {
                    slidesPerView: 2 
                },
                992: {
                    slidesPerView: 3 
                },
                1025: {
                    slidesPerView: 4 
                }
            },
            spaceBetween: 30,
            grabCursor: true,
            pagination: {
                el: ".swiper-col4-pagination-" + index,
                clickable: true,
            }
        });
    });
   
    /*-----------------------------------------------------------------------------------*/
    /*	SLIDER REVOLUTION
    /*-----------------------------------------------------------------------------------*/
  
    $('#slider2').revolution({
        sliderType: "standard",
        sliderLayout: "fullscreen",
        fullScreenOffsetContainer: ".navbar:not(.fixed)",
        spinner: "spinner2",
        delay: 9000,
        shadow: 0,
        gridwidth: [1140, 1024, 778, 480],
        responsiveLevels: [1240, 1024, 778, 480],
        navigation: {
            arrows: {
                enable: true,
                hide_onleave: true,
                style: 'uranus',
                tmp: ''
            },
            touch: {
                touchenabled: 'on',
                swipe_threshold: 75,
                swipe_min_touches: 1,
                swipe_direction: 'horizontal',
                drag_block_vertical: true
            },
            bullets: {
                enable: true,
                style: 'zeus',
                tmp: '<span class="tp-bullet-image"></span><span class="tp-bullet-imageoverlay"></span>',
                hide_onleave: true,
                hide_onmobile: true,
                h_align: "center",
                v_align: "bottom",
                space: 8,
                h_offset: 0,
                v_offset: 20
            }
        }
    });
  
    /*-----------------------------------------------------------------------------------*/
    /*	INSTAGRAM
    /*-----------------------------------------------------------------------------------*/
  
	if ($("#instafeed4").length > 0) {
		$("#instafeed4").instastory({
			get: '@aruno69',
			imageSize: 240,
			limit: 10,
			template: '<div class="swiper-slide"><figure class="overlay overlay3"><a href="{{link}}" target="_blank"><span class="bg"></span><img src="{{image}}" /><figcaption class="d-flex"><div class="align-self-center mx-auto"><i class="fa fa-instagram"></i></div></figcaption></figure></div>',
			after: function()
			{
				var swiperinstagram2 = new Swiper('.swiper-instagram2', {
	                spaceBetween: 0,
	                grabCursor: true,
	                slidesPerView: 2,
		            breakpoints: {
		                768: {
		                    slidesPerView: 3 
		                },
						992: {
		                    slidesPerView: 4 
		                },
		                1025: {
		                    slidesPerView: 5 
		                },
						1200: {
		                    slidesPerView: 6 
		                },
		            },
	                pagination: {
	                    el: '.swiper-instagram-pagination2',
	                    clickable: true,
	                },
	            });
			}
		});
    }
  
    /*-----------------------------------------------------------------------------------*/
    /*	IMAGE ICON HOVER
    /*-----------------------------------------------------------------------------------*/
    $('.overlay > a, .overlay > span').prepend('<span class="bg"></span>');
    /*-----------------------------------------------------------------------------------*/
    /*	COUNTDOWN
	/*-----------------------------------------------------------------------------------*/
    $(".countdown").countdown();
    /*-----------------------------------------------------------------------------------*/
    /*	COUNTER UP
    /*-----------------------------------------------------------------------------------*/
    $('.counter .value').counterUp({
        delay: 50,
        time: 1000
    });
    /*-----------------------------------------------------------------------------------*/
    /*	AOS
    /*-----------------------------------------------------------------------------------*/
    AOS.init({
        easing: 'ease-in-out-sine',
        duration: 800,
        once: true
    });
    
    /*-----------------------------------------------------------------------------------*/
    /*	PROGRESSBAR
	/*-----------------------------------------------------------------------------------*/
    var $pcircle = $('.progressbar.full-circle');
    var $pline = $('.progressbar.line');

    $pcircle.each(function(i) {
        var circle = new ProgressBar.Circle(this, {
            strokeWidth: 4,
            trailWidth: 4,
            duration: 2000,
            easing: 'easeInOut',
            step: function(state, circle, attachment) {
                circle.setText(Math.round(circle.value() * 100));
            }
        });

        var value = ($(this).attr('data-value') / 100);
        $pcircle.waypoint(function() {
            circle.animate(value);
        }, {
            offset: "100%"
        })
    });
    $pline.each(function(i) {
        var line = new ProgressBar.Line(this, {
            strokeWidth: 3,
            trailWidth: 3,
            duration: 3000,
            easing: 'easeInOut',
            text: {
                style: {
                    color: 'inherit',
                    position: 'absolute',
                    right: '0',
                    top: '-30px',
                    padding: 0,
                    margin: 0,
                    transform: null
                },
                autoStyleContainer: false
            },
            step: function(state, line, attachment) {
                line.setText(Math.round(line.value() * 100) + ' %');
            }
        });
        var value = ($(this).attr('data-value') / 100);
        $pline.waypoint(function() {
            line.animate(value);
        }, {
            offset: "100%"
        })
    });
    
    /*-----------------------------------------------------------------------------------*/
    /*	TOOLTIP
    /*-----------------------------------------------------------------------------------*/
    $('.has-tooltip').tooltip();
    $('.has-popover').popover({
        trigger: 'focus'
    });
    /*-----------------------------------------------------------------------------------*/
    /*	LIGHTGALLERY
    /*-----------------------------------------------------------------------------------*/
    var $lg = $('.light-gallery');
    $lg.lightGallery({
        thumbnail: false,
        selector: 'a',
        mode: 'lg-fade',
        download: false,
        autoplayControls: false,
        zoom: false,
        fullScreen: false,
        videoMaxWidth: '1500px',
        loop: false,
        hash: true,
        mousewheel: false,
        videojs: true,
        share: false
    });
    /*-----------------------------------------------------------------------------------*/
    /*	CUBE
    /*-----------------------------------------------------------------------------------*/
    var $cubegrid = $('#cube-grid');
    $cubegrid.cubeportfolio({
        filters: '#cube-grid-filter',
        loadMore: '#cube-grid-more',
        loadMoreAction: 'click',
        layoutMode: 'grid',
        mediaQueries: [{width: 1440, cols: 3}, {width: 1024, cols: 3}, {width: 768, cols: 3}, {width: 575, cols: 2}, {width: 480, cols: 1}],
        defaultFilter: '*',
        animationType: 'quicksand',
        gapHorizontal: 15,
        gapVertical: 15,
        gridAdjustment: 'responsive',
        caption: 'fadeIn',
        displayType: 'bottomToTop',
        displayTypeSpeed: 100,
        plugins: {
            loadMore: {
                loadItems: 4
            }
        }

    });
    $cubegrid.on('onAfterLoadMore.cbp', function(event, newItemsAddedToGrid) {
        $('.cbp-item-load-more .overlay > a, .cbp-item-load-more .overlay > span').prepend('<span class="bg"></span>');
        // first destroy the gallery
        $lg.data('lightGallery').destroy(true);
        // reinit the gallery
        $lg.lightGallery({
	        thumbnail: false,
	        selector: 'a',
	        mode: 'lg-fade',
	        download: false,
	        autoplayControls: false,
	        zoom: false,
	        fullScreen: false,
	        videoMaxWidth: '1000px',
	        loop: false,
	        hash: true,
	        mousewheel: false,
	        videojs: true,
	        share: false
	    });
        
    });
  
    var $cubemosaic = $('#cube-grid-mosaic');
    $cubemosaic.cubeportfolio({
        filters: '#cube-grid-mosaic-filter',
        loadMore: '#cube-grid-mosaic-more',
        loadMoreAction: 'click',
        layoutMode: 'mosaic',
        mediaQueries: [{width: 1440, cols: 4}, {width: 1024, cols: 4}, {width: 768, cols: 3}, {width: 575, cols: 2}, {width: 320, cols: 1}],
        defaultFilter: '*',
        animationType: 'quicksand',
        gapHorizontal: 0,
        gapVertical: 0,
        gridAdjustment: 'responsive',
        caption: 'fadeIn',
        displayType: 'bottomToTop',
        displayTypeSpeed: 100,
        plugins: {
            loadMore: {
                loadItems: 4
            }
        }

    });
    $cubemosaic.on('onAfterLoadMore.cbp', function(event, newItemsAddedToGrid) {
        $('.cbp-item-load-more .overlay > a, .cbp-item-load-more .overlay > span').prepend('<span class="bg"></span>');
        // first destroy the gallery
        $lg.data('lightGallery').destroy(true);
        // reinit the gallery
        $lg.lightGallery({
	        thumbnail: false,
	        selector: 'a',
	        mode: 'lg-fade',
	        download: false,
	        autoplayControls: false,
	        zoom: false,
	        fullScreen: false,
	        videoMaxWidth: '1500px',
	        loop: true,
	        hash: true,
	        mousewheel: false,
	        videojs: true,
	        share: false
	    });
        
    });
   
    /*-----------------------------------------------------------------------------------*/
    /*	PRETTIFY
    /*-----------------------------------------------------------------------------------*/
    window.prettyPrint && prettyPrint();

    /*-----------------------------------------------------------------------------------*/
    /*	BACKGROUND IMAGE
    /*-----------------------------------------------------------------------------------*/
    $(".bg-image").css('background-image', function() {
        var bg = ('url(' + $(this).data("image-src") + ')');
        return bg;
    });
    /*-----------------------------------------------------------------------------------*/
    /*	GO TO TOP
    /*-----------------------------------------------------------------------------------*/
    $.scrollUp({
        scrollName: 'scrollUp',
        // Element ID
        scrollDistance: 300,
        // Distance from top/bottom before showing element (px)
        scrollFrom: 'top',
        // 'top' or 'bottom'
        scrollSpeed: 300,
        // Speed back to top (ms)
        easingType: 'linear',
        // Scroll to top easing (see http://easings.net/)
        animation: 'fade',
        // Fade, slide, none
        animationInSpeed: 200,
        // Animation in speed (ms)
        animationOutSpeed: 200,
        // Animation out speed (ms)
        scrollText: '<span class="btn btn-square btn-full-rounded btn-icon"><i class="fa fa-chevron-up"></i></span>',
        // Text for element, can contain HTML
        scrollTitle: false,
        // Set a custom <a> title if required. Defaults to scrollText
        scrollImg: false,
        // Set true to use image
        activeOverlay: false,
        // Set CSS color to display scrollUp active point, e.g '#00FFFF'
        zIndex: 1001 // Z-Index for the overlay
    });
    /*-----------------------------------------------------------------------------------*/
    /*	PARALLAX MOBILE
    /*-----------------------------------------------------------------------------------*/
    if (navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i)) {
		$('.image-wrapper').addClass('mobile');
	}
   
	/*-----------------------------------------------------------------------------------*/
    /*	FOOTER REVEAL
    /*-----------------------------------------------------------------------------------*/
	if ( $('.footer-reveal').length ) {
		$('.footer-reveal').footerReveal({
			shadow: false
		});
	}
    /*-----------------------------------------------------------------------------------*/
    /*	PAGE LOADING
    /*-----------------------------------------------------------------------------------*/
	$('.page-loading').delay(350).fadeOut('slow');
    $('.page-loading .status').fadeOut('slow');  
   
});

 


