/*
 *
 *		CUSTOM.JS
 *
 */

(function($){

	"use strict";

	// DETECT TOUCH DEVICE //
	function is_touch_device() {
		return !!('ontouchstart' in window) || ( !! ('onmsgesturechange' in window) && !! window.navigator.maxTouchPoints);
	}


	// SHOW/HIDE MOBILE MENU //
	function show_hide_mobile_menu() {

		$("#mobile-menu-button").on("click", function(e) {

			e.preventDefault();

			$("#mobile-menu").slideToggle(300);

		});

	}


	// MOBILE MENU //
	function mobile_menu() {

		if ($(window).width() < 992) {

			if ($("#page-wrapper > header .menu").length > 0) {

				if ($("#mobile-menu").length < 1) {

					$("#page-wrapper > header .menu").clone().attr({
						id: "mobile-menu",
						class: ""
					}).insertAfter("header");

					$("#mobile-menu .megamenu > a").on("click", function(e) {



                        if( !$(this).hasClass('open') ) {
                            e.preventDefault();
                            $(this).toggleClass("open").next("div").slideToggle(300);
                        }





					});

					$("#mobile-menu .dropdown > a").on("click", function(e) {
                        if( !$(this).hasClass('open') ) {
						    e.preventDefault();

						    $(this).toggleClass("open").next("ul").slideToggle(300);
                        }

					});

				}

			}

		} else {

			$("#mobile-menu").hide();

		}

	}

	// EQUALIZE HEADER ELEMENTS HEIGHT //

	function max2(a, b){
		if ( undefined === a ){ a = 0; }
		if ( undefined === b ){ b = 0; }
		if ( a > b ){
			return a;
		} else {
			return b;
		}
	}

	function equalize_header() {

		var $logoHolder = $('header .logo-holder');
		var $navHolder = $('header .nav-holder');
		var $searchButtonHolder = $('header .search-button-holder');
		var $mobileMenuButtonHolder = $('header .mobile-menu-button-holder');

		var $logo = $('header .logo-holder .logo-wrapper');
		var $nav = $('header .nav-holder nav');
		var $searchButton = $('header .search-button-holder .search-button');
		var $mobileMenuButton = $('header .mobile-menu-button-holder .mobile-menu-button');

		var logoHeight = $logo.outerHeight(true);
		var navHeight = $nav.outerHeight(true);
		var searchButtonHeight = $searchButton.outerHeight(true);
		var mobileMenuButtonHeight = $mobileMenuButton.outerHeight(true);

		$logoHolder.css('height', '');
		$navHolder.css('height', '');
		$searchButtonHolder.css('height', '');
		$mobileMenuButtonHolder.css('height', '');

		// console.log(logoHeight);
		// console.log(navHeight);
		// console.log(searchButtonHeight);
		// console.log(mobileMenuButtonHeight);

		var equalizedHeight = max2( max2( max2( logoHeight,navHeight ), searchButtonHeight ), mobileMenuButtonHeight);

		$logoHolder.css('height', equalizedHeight);
		$navHolder.css('height', equalizedHeight);
		$searchButtonHolder.css('height', equalizedHeight);
		$mobileMenuButtonHolder.css('height', equalizedHeight);

	}


	// SEARCH //
	function search_form() {

		$(".search-button").on("click", function(e) {

			e.preventDefault();
			$("#search-container").insertBefore("header");

			if(!$(".search-button").hasClass("open")) {

				$("#search-container").slideDown(200).addClass("open");
				$(this).addClass("open");

			} else {

				$("#search-container").slideUp(200).removeClass("open");
				$(this).removeClass("open");

			}

		});

	 }


	// STICKY //
	function sticky_header() {

		if ($(window).width() > 991) {

			var $logoHolder = $('header .logo-holder');
			var $navHolder = $('header .nav-holder');
			var $searchButtonHolder = $('header .search-button-holder');

			$('header').on('fixed.shira.scrollfix unfixed.shira.scrollfix', function (e) {

				equalize_header()
				
				$logoHolder.css('-webkit-transition', 'all 0.3s').css('transition', 'all 0.3s');
				$navHolder.css('-webkit-transition', 'all 0.3s').css('transition', 'all 0.3s');
				$searchButtonHolder.css('-webkit-transition', 'all 0.3s').css('transition', 'all 0.3s');

			})

			$('header').on('unfixed.shira.scrollfix', function (e) {

				$logoHolder.css('-webkit-transition', '').css('transition', '');
				$navHolder.css('-webkit-transition', '').css('transition', '');
				$searchButtonHolder.css('-webkit-transition', '').css('transition', '');

			})

			// apply scrollfix

			var headerHeight = $('#page-wrapper > header').outerHeight();

			$("header").scrollFix({
				fixClass: "header-sticky",
				fixTop: 0,
				fixOffset: headerHeight,
				unfixOffset: headerHeight
			});

		}

	}




	// PROGRESS BARS //
	function progress_bars() {

		$(".progress .progress-bar:in-viewport").each(function() {

			if (!$(this).hasClass("animated")) {
				$(this).addClass("animated");
				$(this).animate({
					width: $(this).attr("data-width") + "%"
				}, 2000);
			}

		});

	}


	// CHARTS //
	function pie_chart() {

		$(".pie-chart:in-viewport").each(function() {

			$(this).easyPieChart({
				animate: 1500,
				lineCap: "square",
				lineWidth: $(this).attr("data-line-width"),
				size: $(this).attr("data-size"),
				barColor: $(this).attr("data-bar-color"),
				trackColor: $(this).attr("data-track-color"),
				scaleColor: "transparent",
				onStep: function(from, to, percent) {
					$(this.el).find('.pie-chart-details .value').text(Math.round(percent));
				}
			});

		});

	}


	// COUNTER //
	function counter() {

		$(".counter .counter-value:in-viewport").each(function() {

			if (!$(this).hasClass("animated")) {
				$(this).addClass("animated");
				$(this).jQuerySimpleCounter({
					start: 0,
					end: $(this).attr("data-value"),
					duration: 2000
				});
			}

		});

	}




	// LOAD MORE PROJECTS //
	function load_more_projects() {

		var number_clicks = 0;

		$(".load-more").on("click", function(e) {

			e.preventDefault();

			if (number_clicks == 0) {
				$.ajax({
					type: "POST",
					url: $(".load-more").attr("href"),
					dataType: "html",
					cache: false,
					msg : '',
					success: function(msg) {
						$(".isotope").append(msg);
						$(".isotope").imagesLoaded(function() {
							$(".isotope").isotope("reloadItems").isotope();
							$(".fancybox-portfolio-gallery").attr("rel","group").fancybox({
								prevEffect: 'none',
								nextEffect: 'none'
							});

							$(".fancybox-blog-gallery").attr("rel","group").fancybox({
								prevEffect: 'none',
								nextEffect: 'none'
							});
						});
						number_clicks++;
						$(".load-more").html("No more project");
					}
				});
			}

		});

	}


	// SHOW/HIDE GO TOP //
	function show_hide_go_top() {

		if ($(window).scrollTop() > $(window).height()/2) {
			$("#go-top").fadeIn(300);
		} else {
			$("#go-top").fadeOut(300);
		}

	}


	// GO TOP //
	function go_top() {

		$("#go-top").on("click", function () {
			$("html, body").animate({
				scrollTop: 0
			}, 800);
			return false;
		});

	}

	// FULL SCREEN //
	function full_screen() {

		var $next_section_after_header;

		if( 0 == $(".full-screen, .bannercontainer > .rev_slider_wrapper.fullscreen-container").size() ){
			return;
		}

		$(".full-screen").css("height", $(window).height() + "px");

		$next_section_after_header = $('#page-wrapper > header').next();

		if( 0 == $next_section_after_header ){
			return;
		}

		if( $next_section_after_header.hasClass('full-screen') ){
			$('body').addClass('fullscreen-body');
		}

		if( $next_section_after_header.hasClass('bannercontainer') ){
			if( $next_section_after_header.find('.rev_slider_wrapper.fullscreen-container') ){
				$('body').addClass('fullscreen-body');
			}
		}
	}


	// ANIMATIONS //
	function animations() {

		animations = new WOW({
			boxClass: 'wow',
			animateClass: 'animated',
			offset: 100,
			mobile: false,
			live: true
		})

		animations.init();

	}


	// SMOOTH SCROLLING //
	function get_menu_height(){
		var menu_height = 0;
		if( 1 == $('#page-wrapper header:first-child').size() ){
			menu_height += $('#page-wrapper header:first-child').height();
		}
		if( 1 == $('#wpadminbar').size() ){
			menu_height += $('#wpadminbar').height();
		}
		return menu_height;
	}

	function smooth_scrolling() {

		$(".scrollspy-menu a").on("click", function (e) {
			var target = this.hash;
			var $target = $(target);

			if( 0 == $target.size() ){
				return;
			}

			$target.attr( 'id', '' );
			window.location.hash = target;
			$target.attr( 'id', target.substring(1) );

			$("html, body").stop().animate( {
				'scrollTop': $target.offset().top - get_menu_height()
			}, 900, 'swing', function () {
				$("html, body").stop().animate( {
					'scrollTop': $target.offset().top - get_menu_height()
				}, 200, 'swing');
			});

			e.preventDefault();
			return false;
		});

	}

	function smooth_scrolling_onload(){

		window.setTimeout(function(){
			var _id = '';
			if( -1 < window.location.href.indexOf("#") ) {
				_id = '#' + window.location.href.split( '#' )[1];

				$("html, body").stop().animate( {
					'scrollTop': $(_id).offset().top - get_menu_height()
				}, 200, 'swing', function () {
				});
			}
		},100);

	}

    function twitter_widget() {
        	/* Twitter Slider */

        $('#tweet ul').bxSlider({
             mode: 'vertical',
             speed: 500,
             infiniteLoop: true,
             hideControlOnEnd: false,
             pager: false,
             pagerType: 'full',
             controls: true,
             auto: true,
             pause: 4000,
             autoHover: true,
             useCSS: false,
             nextSelector: '#twitter-slider-next',
             prevSelector: '#twitter-slider-prev',
             nextText: '<i class="fa fa-angle-down"></i>',
             prevText: '<i class="fa fa-angle-up"></i>'
        });
    }


	// DOCUMENT READY //
	$(document).ready(function(){

		$('.tab-content .tab-pane').first().addClass('active in');

		// MENU //
		$("#page-wrapper > header .menu").superfish({
			delay: 500,
			animation: {
				opacity: 'show',
				height: 'show'
			},
			speed: 'normal',
			cssArrows: false
		});


		//SHOW/HIDE MOBILE MENU //
		show_hide_mobile_menu();


		// MOBILE MENU //
		mobile_menu();


		// SEARCH //
		search_form();

        // TWITTER
        twitter_widget();


		// STICKY //
		sticky_header();

		$(".elements-menu").scrollFix({
			fixClass: "elements-menu-sticky",
			fixTop: 0,
			fixOffset: 0
		});

		equalize_header()

		// TABLE BOOTSTRAP //

		$('.page-content table, .post-content table').addClass('table');


		// FANCYBOX //
		$(".fancybox").fancybox({});

		$(".fancybox-portfolio-gallery").attr("rel","group").fancybox({
			prevEffect: 'none',
			nextEffect: 'none'
		});

		$(".fancybox-blog-gallery").attr("rel","group").fancybox({
			prevEffect: 'none',
			nextEffect: 'none'
		});

		// BxSLIDER //
		$(".info-slider ul").bxSlider({
			mode: 'fade',
			speed: 800,
			infiniteLoop: true,
			minSlides:3,
			hideControlOnEnd: false,
			pager: true,
			autoHidePager: true,
			hidePagerOnSinglePage: true,
			pagerType: 'full',
			controls: false,
			auto: true,
			pause: 4000,
			autoHover: true,
			useCSS: false
		});

		$('.testimonial-slider').each(function(){
			var $ul = $(this).find('ul');
			var $pager = $(this).find('.thumb-pager');

			$ul.bxSlider({
			mode: 'fade',
			speed: 800,
			infiniteLoop: true,
			hideControlOnEnd: false,
			pager: true,
			pagerType: 'full',
			controls: false,
			auto: false,
			pause: 4000,
			autoHover: true,
			useCSS: false,
			pagerCustom: $pager
		});


		});
		//$(".testimonial-slider ul")

		$(".testimonial-slider-2 ul").bxSlider({
			mode: 'fade',
			speed: 800,
			infiniteLoop: true,
			hideControlOnEnd: false,
			pager: true,
			pagerType: 'full',
			controls: false,
			auto: false,
			pause: 4000,
			autoHover: true,
			useCSS: false
		});

		$(".project-slider ul").bxSlider({
			mode: 'fade',
			speed: 800,
			infiniteLoop: true,
			hideControlOnEnd: false,
			pager: true,
			pagerType: 'full',
			controls: false,
			auto: false,
			pause: 4000,
			autoHover: true,
			useCSS: false,
			pagerCustom: '#project-slider-control'
		});

		$(".images-slider ul").bxSlider({
			mode: 'horizontal',
			speed: 800,
			infiniteLoop: true,
			hideControlOnEnd: false,
			pager: true,
			pagerType: 'full',
			controls: false,
			auto: true,
			pause: 4000,
			autoHover: true,
			useCSS: false
		});

		$(".images-slider-2 ul").bxSlider({
			mode: 'horizontal',
			speed: 800,
			infiniteLoop: true,
			hideControlOnEnd: false,
			pager: false,
			pagerType: 'full',
			controls: true,
			auto: true,
			pause: 4000,
			autoHover: true,
			useCSS: false
		});

/**********************************************************************************************************************/
/* FRESHFACE EDIT START - MAP
/**********************************************************************************************************************/
		// ORIGINAL CODE
		// GOOGLE MAPS //
		//$(".map").gMap({
		//	maptype: 'ROADMAP',
		//	scrollwheel: false,
		//	zoom: 11,
		//	markers: [{
		//		address: 'San Jose, California, USA',
		//		html: 'MILO Office'
		//	}],
		//	controls: {
		//		panControl: true,
		//		zoomControl: true,
		//		mapTypeControl: true,
		//		scaleControl: false,
		//		streetViewControl: false,
		//		overviewMapControl: false
		//	}
		//});

		$('.map').each(function(){
			var address = $(this).attr('data-address');
			var description = $(this).attr('data-description');
			var zoom = parseInt($(this).attr('data-zoom'));

			$(this).gMap({
				maptype: 'ROADMAP',
				scrollwheel: false,
				zoom: zoom,
				markers: [{
					address: address,
					html: description
				}],
				controls: {
					panControl: true,
					zoomControl: true,
					mapTypeControl: true,
					scaleControl: false,
					streetViewControl: false,
					overviewMapControl: false
				}
			});
		});
/**********************************************************************************************************************/
/* FRESHFACE EDIT END - MAP
/**********************************************************************************************************************/

		// ISOTOPE //
		$(".isotope").imagesLoaded( function() {

			var container = $(".isotope");

			container.isotope({
				itemSelector: '.isotope-item',
				layoutMode: 'masonry',
				transitionDuration: '0.8s'
			});

			$(".filter li a").on("click", function () {
				$(".filter li a").removeClass("active");
				$(this).addClass("active");

				var selector = $(this).attr("data-filter");
				container.isotope({
					filter: selector
				});

				return false;
			});

			$("body").resize(function () {
				container.isotope();
			});

		});


		// LOAD MORE PORTFOLIO ITEMS //
		load_more_projects();


		// PLACEHOLDER //
		$("input, textarea").placeholder();

/**********************************************************************************************************************/
/* FRESHFACE EDIT CONTACT FORM START
/**********************************************************************************************************************/
		// CONTACT FORM VALIDATE & SUBMIT //
		// VALIDATE //

		$('.ff-cform').each(function(){

			var $messages = $(this).find('.ff-contact-messages');
			var $contactForm = $(this);
			$(this).validate({
				rules: {
					name: {
						required: true
					},
					email: {
						required: true,
						email: true
					},
					subject: {
						required: true
					},
					message: {
						required: true,
						minlength: 10
					}
				},

				messages: {
					name: {
						required: $messages.find('.ff-validation-name').html()
					},
					email: {
						required: $messages.find('.ff-validation-email').html(),
						email: $messages.find('.ff-validation-email-format').html()
					},
					subject: {
						required: $messages.find('.ff-validation-subject').html()
					},
					message: {
						required: $messages.find('.ff-validation-message').html(),
						minlength: jQuery.validator.format( $messages.find('.ff-validation-message-minlength').html() )
					}
				},

				submitHandler: function( form ) {

					var serializedContent = $contactForm.serialize();


					var data = {};
					data.formInput = serializedContent;
					data.contactInfo = $contactForm.find('.ff-contact-info').html();

					frslib.ajax.frameworkRequest('contactform-send-ajax', null, data, function( response ) {
						var result = '';
						if( response == 'true' ) {
							result = $messages.find('.ff-message-send-ok').html();
							$contactForm.clearForm();
						} else {
							result = $messages.find('.ff-message-send-wrong').html();
						}

						$contactForm.find("#alert-area").html(result);

					});
				}
			});

		});

		//$("#contact-form").validate({
		//	rules: {
		//		name: {
		//			required: true
		//		},
		//		email: {
		//			required: true,
		//			email: true
		//		},
		//		subject: {
		//			required: true
		//		},
		//		message: {
		//			required: true,
		//			minlength: 10
		//		}
		//	},
		//	messages: {
		//		name: {
		//			required: "Please enter your name!"
		//		},
		//		email: {
		//			required: "Please enter your email!",
		//			email: "Please enter a valid email address"
		//		},
		//		subject: {
		//			required: "Please enter the subject!"
		//		},
		//		message: {
		//			required: "Please enter your message!",
		 //           minlength: jQuery.validator.format("At least {0} characters required")
		//		}
		//	},
		//
		//	// SUBMIT //
		//	submitHandler: function(form) {
		//		var result;
		//		$(form).ajaxSubmit({
		//			type: "POST",
		//			data: $(form).serialize(),
		//			url: "assets/php/send.php",
		//			success: function(msg) {
		//
		//				if (msg == 'OK') {
		//					result = '<div class="alert alert-success">Your message was successfully sent!</div>';
		//					$("#contact-form").clearForm();
		//				} else {
		//					result = msg;
		//				}
		//
		//				$("#alert-area").html(result);
		//
		//			},
		//			error: function() {
		//
		//				result = '<div class="alert alert-danger">There was an error sending the message!</div>';
		//				$("#alert-area").html(result);
		//
		//			}
		//		});
		//	}
		//});
/**********************************************************************************************************************/
/* FRESHFACE EDIT CONTACT FORM END
/**********************************************************************************************************************/


		// TO LONG SUBMENU FIX //

		$("#page-wrapper > header ul.menu ul li").hover(function(){
			var body_width = $('body').width();
			var $m = $(this);
			var lft = $(this).offset().left;
			var wdt = $(this).width();
			if( lft + 2 * wdt + 100 > body_width ){
				$(this).children('ul').addClass('open-on-left');
			}else{
				$(this).children('ul').removeClass('open-on-left');
			}
		});


		/**********************************************************************************************************************/
		/* FRESHFACE EDIT TOO LONG MENU
		/**********************************************************************************************************************/

		// PARALLX //
		if (!is_touch_device()) {
			$('.parallax').parallaxScroll({
				friction: 0
			});
		}


		// SHOW/HIDE GO TOP
		show_hide_go_top();


		// GO TOP //
		go_top();


		// YOUTUBE PLAYER //
		$(".background-youtube-video .player").each(function(){
			$(this).YTPlayer();
		})


		// ANIMATIONS //
		animations();


		// FULL SCREEN //
		full_screen();


		// SMOOTH SCROLLING
		smooth_scrolling();


		// SCROLLSPY //
		$("body").scrollspy({
			target: '.scrollspy-menu'
		});

	});

	$(window).load(function(){

		smooth_scrolling_onload();
		equalize_header();
		progress_bars();
		pie_chart();
		counter();
		//animate_charts();
		show_hide_go_top();

	});


	// WINDOW SCROLL //
	$(window).scroll(function(){

		progress_bars();
		pie_chart();
		counter();
		//animate_charts();
		show_hide_go_top();

	});


	// WINDOW RESIZE //
	$(window).resize(function(e) {

		mobile_menu();
		full_screen();
		equalize_header()

	});

})(window.jQuery);