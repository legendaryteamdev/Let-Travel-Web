/*
Copyright (c) 2018
------------------------------------------------------------------
[Master Javascript]

Project:	Cycling  - Responsive HTML Template

-------------------------------------------------------------------*/
(function($) {
    "use strict";
    var cycling = {
        initialised: false,
        version: 1.0,
        mobile: false,
        init: function() {
            if (!this.initialised) {
                this.initialised = true;
            } else {
                return;
            }
            /*-------------- Cycling Functions Calling ---------------------------------------------------
            ------------------------------------------------------------------------------------------------*/
            this.RTL();
            this.Fixedmenu();
            this.Togglemenu();
            this.Slider();
            this.Counter();
            this.Sponsors();
            this.Result();
            this.Grid_List_view();
            this.Range_slider();
            this.Store();
            this.Gallery();
            this.Search();
            this.Thumbnail_slider();
            this.Popup();
            this.Select();
			this.Wow();
        },
        /*-------------- Cycling Functions definition ---------------------------------------------------
        ---------------------------------------------------------------------------------------------------*/
        RTL: function() {
            var rtl_attr = $("html").attr('dir');
            if (rtl_attr) {
                $('html').find('body').addClass("rtl");
            }
        },
        // Fixed Menu
        Fixedmenu: function() {
            if ($('.cy_top_wrapper').length > 0) {
                var height = $('.cy_top_wrapper').outerHeight();
                $('.cy_menu_wrapper').css("top", height);
            }
        },
        //Menu
        Togglemenu: function() {
            $(".cy_menu_btn").on('click', function() {
                $(".cy_menu_wrapper").toggleClass('open_menu');
            });
            $(".cy_menu_close").on('click', function() {
                $(".cy_menu_wrapper").removeClass('open_menu');
            });
            $('.cy_menu ul li.dropdown').children('a').append(function() {
                return '<div class="dropdown-expander"><i class="fa fa-bars"></i></div>';
            });
            $(".cy_menu ul > li:has(ul) > a").on('click', function(e) {
                var w = window.innerWidth;
                if (w <= 991) {
                    e.preventDefault();
                    $(this).parent('.cy_menu ul li').children('ul.sub-menu').slideToggle();
                }
            });
        },
        //Banner Slider
        Slider: function() {
            if ($(".rev_slider_wrapper").length) {
                var tpj = jQuery;
                var revapi1068;
                tpj(document).ready(function() {
                    if (tpj("#rev_slider_1068_1").revolution == undefined) {
                        revslider_showDoubleJqueryError("#rev_slider_1068_1");
                    } else {
                        revapi1068 = tpj("#rev_slider_1068_1").show().revolution({
                            sliderType: "standard",
                            jsFileLocation: "plugin/revolution/js",
                            sliderLayout: "fullscreen",
                            dottedOverlay: "none",
                            delay: 9000,
                            navigation: {
                                keyboardNavigation: "off",
                                keyboard_direction: "horizontal",
                                mouseScrollNavigation: "off",
                                mouseScrollReverse: "default",
                                onHoverStop: "off",
                                touch: {
                                    touchenabled: "off",
                                    swipe_threshold: 75,
                                    swipe_min_touches: 1,
                                    swipe_direction: "vertical",
                                    drag_block_vertical: false
                                },
                                bullets: {
                                    enable: true,
                                    hide_onmobile: true,
                                    hide_under: 1024,
                                    style: "uranus",
                                    hide_onleave: false,
                                    direction: "vertical",
                                    h_align: "right",
                                    v_align: "center",
                                    h_offset: 30,
                                    v_offset: 0,
                                    space: 5,
                                    tmp: '<span class="tp-bullet-inner"></span>'
                                }
                            },
                            viewPort: {
                                enable: true,
                                outof: "wait",
                                visible_area: "80%",
                                presize: false
                            },
                            responsiveLevels: [1240, 1024, 778, 480],
                            visibilityLevels: [1240, 1024, 778, 480],
                            gridwidth: [1240, 1024, 778, 480],
                            gridheight: [868, 768, 960, 720],
                            lazyType: "single",
                            shadow: 0,
                            spinner: "off",
                            stopLoop: "off",
                            stopAfterLoops: -1,
                            stopAtSlide: -1,
                            shuffle: "off",
                            autoHeight: "off",
                            autoPlay: "off",
                            fullScreenAutoWidth: "off",
                            fullScreenAlignForce: "off",
                            fullScreenOffsetContainer: ".header",
                            fullScreenOffset: "",
                            disableProgressBar: "on",
                            hideThumbsOnMobile: "off",
                            hideSliderAtLimit: 0,
                            hideCaptionAtLimit: 0,
                            hideAllCaptionAtLilmit: 0,
                            debugMode: false,
                            fallbacks: {
                                simplifyAll: "off",
                                nextSlideOnWindowFocus: "off",
                                disableFocusListener: false,
                            }
                        });
                    }
                });
            }
        },
        //Counter
        Counter: function() {
            if ($('.cy_count_box').length > 0) {
                $('.cy_count_box').appear(function() {
                    $('.cy_counter_num').countTo();
                });
            }
        },
        //Sponsors Slider
        Sponsors: function() {
            $('.cy_sponsor_slider .owl-carousel').owlCarousel({
                loop: true,
                margin: 30,
                nav: false,
                dots: false,
                autoplaySpeed: 1500,
                autoplay: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    800: {
                        items: 3
                    },
                    1000: {
                        items: 4
                    }
                }
            })
        },
        //Result Slider
        Result: function() {
            $('.cy_result_slider .owl-carousel').owlCarousel({
                loop: true,
                margin: 30,
                nav: true,
                dots: false,
                navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>' ],
                autoplaySpeed: 1500,
                autoplay: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    800: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
                }
            })
        },
        // Grid List view
        Grid_List_view:function(){
            if($('.cy_shop_view').length > 0){
                $('.cy_shop_view').on('click', 'li', function() {
                    $('.cy_shop_view ul li.active').removeClass('active');
                    $(this).addClass('active');
                });
                $('#list').click(function(event){event.preventDefault();$('#products .item').addClass('list-group-item');});
                $('#grid').click(function(event){event.preventDefault();$('#products .item').removeClass('list-group-item');$('#products .item').addClass('grid-group-item');});
            }
        },
        // Range_slider
        Range_slider:function(){
            if($('.widget_price').length > 0){
                $( function() {
                    $( "#slider-range" ).slider({
                        range: true,
                        min: 0,
                        max: 10000,
                        values: [ 2000, 8000 ],
                        slide: function( event, ui ) {
                            $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
                        }
                    });
                    $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
                        " - $" + $( "#slider-range" ).slider( "values", 1 ) );
                });
            }
        },
        //Store Slider
        Store: function() {
            $('.cy_store_slider .owl-carousel').owlCarousel({
                loop: true,
                margin: 30,
                nav: true,
                dots: false,
                navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>' ],
                autoplaySpeed: 1500,
                autoplay: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    800: {
                        items: 2
                    },
                    1000: {
                        items: 3
                    }
                }
            })
        },
        //Gallery
        Gallery: function() {
            $('.cy_gallery_wrapper').magnificPopup({
                delegate: 'a.fa-search',
                type: 'image',
                mainClass: 'mfp-with-zoom',
                gallery: {
                    enabled: true,
                },
                zoom: {
                    enabled: true,
                    duration: 400,
                    easing: 'ease-in-out',
                    opener: function(openerElement) {
                        return openerElement.is('a') ? openerElement : openerElement.find('img');
                    }
                },
            });
        },
        Search: function() {
            $('.search_open').on('click',function(){
                $('.cy_search_form').addClass('search_opened')  
            });
            $('.search_close').on('click',function(){
                $('.cy_search_form').removeClass('search_opened')  
            });
        },
        Thumbnail_slider: function(){
            var sync1 = $("#sync1");
              var sync2 = $("#sync2");
              var slidesPerPage = 4;
              var syncedSecondary = true;
              sync1.owlCarousel({
                items : 1,
                slideSpeed : 2000,
                nav: false,
                autoplay: true,
                dots: false,
                mouseDrag: false,
                loop: true,
                responsiveRefreshRate : 200,
                navText: ['<svg width="100%" height="100%" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>','<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'],
              }).on('changed.owl.carousel', syncPosition);

              sync2
                .on('initialized.owl.carousel', function () {
                  sync2.find(".owl-item").eq(0).addClass("current");
                })
                .owlCarousel({
                items : slidesPerPage,
                dots: false,
                nav: false,
                autoplay:false,
                mouseDrag: false,
                responsiveRefreshRate : 100
              }).on('changed.owl.carousel', syncPosition2);

              function syncPosition(el) {
                var count = el.item.count-1;
                var current = Math.round(el.item.index - (el.item.count/2) - .5);
                
                if(current < 0) {
                  current = count;
                }
                if(current > count) {
                  current = 0;
                }
                
                sync2
                  .find(".owl-item")
                  .removeClass("current")
                  .eq(current)
                  .addClass("current");
                var onscreen = sync2.find('.owl-item.active').length - 1;
                var start = sync2.find('.owl-item.active').first().index();
                var end = sync2.find('.owl-item.active').last().index();
                
                if (current > end) {
                  sync2.data('owl.carousel').to(current, 100, true);
                }
                if (current < start) {
                  sync2.data('owl.carousel').to(current - onscreen, 100, true);
                }
              }
              
              function syncPosition2(el) {
                if(syncedSecondary) {
                  var number = el.item.index;
                  sync1.data('owl.carousel').to(number, 100, true);
                }
              }
              
              sync2.on("click", ".owl-item", function(e){
                e.preventDefault();
                var number = $(this).index();
                sync1.data('owl.carousel').to(number, 300, true);
              });

        },
		Popup:function(){
		   $('.cy_modal').on('click', function(){
			$('.modal-open #signin').hide();
			$('.modal-backdrop').hide();
			$('body').css('padding','0px');
			
		   })
		},
		Select:function(){
		  $('select:not(.ignore)').niceSelect();
		},
        //Wow
        Wow: function() {
            new WOW().init();
        },
    };
    $(document).ready(function() {
        cycling.init();
    });
    //On load
    $(window).on('load', function() {
        var load;
        setTimeout(function() {
            $('body').addClass('load');
        }, 500);
    });

    // Window Scroll
    $(window).scroll(function() {
		var wh = window.innerWidth;
        if (wh > 767) {
            var h = window.innerHeight;
            var window_top = $(window).scrollTop() + 1;
            if (window_top > 100) {
                $('.cy_menu_wrapper').addClass('cy_fixed');
            } else {
                $('.cy_menu_wrapper').removeClass('cy_fixed');
            }
        }
        //Go to top
        if ($(this).scrollTop() > 100) {
            $('.cy_go_to').addClass('goto');
        } else {
            $('.cy_go_to').removeClass('goto');
        }

    });
    $(".cy_go_to").on("click", function() {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false
    });

})(jQuery);